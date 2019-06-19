window.addEventListener("load", (evt) => {
    // groups an object by some key
    // https://gist.github.com/JamieMason/0566f8412af9fe6a1d470aa1e089a752
    const groupBy = key => array =>
        array.reduce((objectsByKeyValue, obj) => {
            const value = obj[key];
            objectsByKeyValue[value] = (objectsByKeyValue[value] || []).concat(obj);
            return objectsByKeyValue;
        }, {});

    // creates an icon element to serve as option
    function createIcon(name, title) {
        let icon = document.createElement("i");
        icon.classList.add("material-icons");
        icon.setAttribute("title", title);
        icon.textContent = name;

        return icon;
    }

    // hides the rate's row element
    function hideRow() {
        this.parentElement.parentElement.classList.add("hidden");
    }

    // deletes every row value via API
    function deleteRowRates() {
        let parentRow = this.parentElement.parentElement;

        parentRow.querySelectorAll("td.rate").forEach(td => {
            fetch("/api/api.php?id=" + td.getAttribute("data-id"), { method: "DELETE" })
                .then(response => response.json())
                .then(json => {
                    if (!json.success) {
                        console.error(json.message);
                    }
                })
                .catch(reason => console.error("Fetch error: " + reason.message));
        });

        // hides the row
        parentRow.classList.add("hidden");
    }

    // creates a td with deletion and hiding options
    function createTdOptions() {
        let tdOptions = document.createElement("td");

        let iconHide = createIcon("remove_red_eye", "Hide");
        iconHide.addEventListener("click", hideRow);

        let iconDel = createIcon("delete", "Delete");
        iconDel.addEventListener("click", deleteRowRates);

        tdOptions.appendChild(iconHide);
        tdOptions.appendChild(iconDel);

        return tdOptions;
    }

    // adds rates as rows in the table
    function addDataRows(rates) {
        let table = document.getElementsByClassName("table")[0];
        let tbody = table.querySelector("tbody");

        // since the rates are grouped by their datetimes, loops through its keys
        Object.keys(rates).forEach(datetime => {
            let currentRates = rates[datetime];

            let row = document.createElement("tr");
            let tdUpdate = document.createElement("td");
            let tdUSD = document.createElement("td");
            let tdEUR = document.createElement("td");
            let tdGBP = document.createElement("td");
            let tdOptions = createTdOptions();

            tdUpdate.textContent = datetime;

            // each datetime will probably have 3 rate values, looped and assigned accordingly
            currentRates.forEach(rate => {
                let currentTd = null;

                switch (rate.symbol) {
                    case "USD": currentTd = tdUSD; break;
                    case "EUR": currentTd = tdEUR; break;
                    case "GBP": currentTd = tdGBP;
                }

                currentTd.setAttribute("data-id", rate.id);
                currentTd.classList.add("rate");
                currentTd.textContent = rate.value ? parseFloat(rate.value).toFixed(2) : "-";
            });

            row.appendChild(tdUpdate);
            row.appendChild(tdUSD);
            row.appendChild(tdEUR);
            row.appendChild(tdGBP);
            row.appendChild(tdOptions);
            row.classList.add("new-row");

            // adds the row before the first one
            tbody.insertBefore(row, tbody.firstChild);
        });
    }

    // gets the rates values since the last id
    function fetchRates(id) {
        fetch("/api/api.php?id=" + id)
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error(data.message);
                    return;
                }

                if (data.rates.length === 0) {
                    return;
                }

                // the current id is now the last one from the result
                currentId = data.rates[data.rates.length - 1].id;

                let rates = groupBy("datetime")(data.rates);
                addDataRows(rates);
            })
            .catch(reason => console.error("Fetch error: " + reason.message));
    }

    // creates a countdown timer to fetch rates every given seconds
    function createFetchInterval() {
        const timeInterval = 30;
        let timeLimit = timeInterval;

        let secondsSpan = document.getElementById("seconds");

        let interval = setInterval(() => {
            secondsSpan.textContent = timeLimit;
            timeLimit--;

            if (timeLimit < 0) {
                timeLimit = timeInterval;

                fetchRates(currentId);
            }
        }, 1000);
    }

    // the id to fetch data from the API
    let currentId = 0;

    fetchRates(currentId);
    createFetchInterval();
});