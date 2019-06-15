CREATE TABLE rates (
    id SERIAL,
    base VARCHAR(3) NOT NULL,
    symbol VARCHAR(3) NOT NULL,
    value DOUBLE NOT NULL,
    datetime TIMESTAMP NOT NULL DEFAULT NOW(),
    PRIMARY KEY (id)
);