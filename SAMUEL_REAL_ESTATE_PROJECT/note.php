create tabele if not EXISTS properties(
    id int AUTO_INCREMENT PRIMARY key,
    title varchar(255) not null,
    description text not null,
    price decimal(10,2) not null,
    bedrooms int not null,
    square_footage varchar(90) not null,
    year_built varchar(90) not null,
    location varchar(255) not null,
    image varchar(255) not null,
    location varchar(255) not null,
    added_by int,
    FOREIGN key (added_by)REFERENCES users(id) 
);


create tabele if not EXISTS user(
    id int AUTO_INCREMENT PRIMARY key,
    first_name varchar(50) not null,
    last_name varchar(50) not null,
    city varchar(50) not null,
    country varchar(50) not null,
    username varchar(50) not null,
    email varchar(100) not null,
    password varchar(255) not null,
    phone varchar(15) not null,
    address text,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP
    
);


