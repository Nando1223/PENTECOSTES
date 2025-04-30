-- SERVER 
CREATE TABLE PENTECOSTES_ASISTENTES (
    ID UNIQUEIDENTIFIER DEFAULT NEWID() PRIMARY KEY, 
    Nombres VARCHAR(150) NOT NULL,                    
    Direccion VARCHAR(250) NULL,                      
    Celular VARCHAR(20) NULL,                       
    Estado BIT DEFAULT 0,
    Creado_date datetime,
    Congregacion varchar(200),
    Cargo varchar(100)                        
);

--MY_SQL
CREATE TABLE pentecostes_asistentes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Identificacion VARCHAR(150) NOT NULL,
    Nombres VARCHAR(150) NOT NULL,
    Direccion VARCHAR(250),
    Celular VARCHAR(20),
    Congregacion VARCHAR(200),
    Cargo VARCHAR(100),
    Estado TINYINT DEFAULT 0,
    Creado_date DATETIME
);
