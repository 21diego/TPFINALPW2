drop database if exists infonete;
create database infonete;
use infonete;

create table pago
(
    id     int primary key auto_increment,
    codigo varchar(50)
);

create table rol
(
    id          int primary key auto_increment,
    codigo      varchar(50),
    descripcion varchar(50)
);

create table localidad
(
    id          int primary key auto_increment,
    codigo      varchar(50),
    descripcion varchar(50)
);

create table persona
(
    id               int primary key auto_increment,
    apellido         varchar(50),
    nombres          varchar(50),
    fecha_nacimiento date,
    id_localidad     int,
    foreign key (id_localidad)
        references localidad (id)
);

create table usuario
(
    id         int primary key auto_increment,
    usuario    varchar(50),
    password   varchar(50),
    id_persona int,
    id_rol     int,
    foreign key (id_persona)
        references persona (id),
    foreign key (id_rol)
        references rol (id),
    unique key unique_nombre (usuario)
);

create table suscripcion
(
    id                   int primary key auto_increment,
    fecha_vigencia_desde date,
    fecha_vigencia_hasta date,
    id_pago              int,
    id_usuario           int,
    foreign key (id_pago)
        references pago (id),
    foreign key (id_usuario)
        references usuario (id)
);

create table estado
(
    id          int primary key auto_increment,
    codigo      varchar(50),
    descripcion varchar(50)
);

create table tipo_publicacion
(
    id          int primary key auto_increment,
    codigo      varchar(50),
    descripcion varchar(50)
);

create table genero_publicacion
(
    id          int primary key auto_increment,
    codigo      varchar(50),
    descripcion varchar(50)
);

create table publicacion
(
    id                  int primary key auto_increment,
    contenido_gratuito  boolean,
    estado_registro     boolean,
    id_genero           int,
    id_tipo_publicacion int,
    id_estado           int,
    foreign key (id_genero)
        references genero_publicacion (id),
    foreign key (id_tipo_publicacion)
        references tipo_publicacion (id),
    foreign key (id_estado)
        references estado (id)
);

create table seccion
(
    id              int primary key auto_increment,
    estado_registro boolean,
    id_publicacion  int,
    id_estado       int,
    foreign key (id_publicacion)
        references publicacion (id),
    foreign key (id_estado)
        references estado (id),
    foreign key (id_publicacion)
        references publicacion (id)
);

create table noticia
(
    id              int primary key auto_increment,
    estado_registro boolean,
    id_seccion      int,
    id_contenidista int,
    id_localidad    int,
    id_estado       int,
    foreign key (id_seccion)
        references seccion (id),
    foreign key (id_contenidista)
        references usuario (id),
    foreign key (id_localidad)
        references localidad (id),
    foreign key (id_estado)
        references estado (id)
);

create table publicacion_usuario
(
    id             int primary key auto_increment,
    id_usuario     int,
    id_publicacion int,
    foreign key (id_usuario)
        references usuario (id),
    foreign key (id_publicacion)
        references publicacion (id)
);



