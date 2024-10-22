create database lunodoroRefactor;

-- drop database lunodoroRefactor;
use lunodoroRefactor;

create table
    usuario (
        id int primary key auto_increment,
        nome_usuario varchar(100) not null,
        email varchar(100) not null unique,
        senha varchar(255) not null,
        dt_criacao_conta timestamp default current_timestamp
    );

create table
    tipo_lista (
        id int primary key auto_increment,
        descricao varchar(20) not null unique
    );

create table
    lista (
        id int primary key auto_increment,
        id_usuario int not null,
        nome_lista varchar(100) not null,
        descricao varchar(255) not null,
        id_tipo_lista int not null,
        dt_criacao timestamp default current_timestamp,
        dt_atualizacao timestamp default current_timestamp on update current_timestamp,
        constraint fk_usuario foreign key (id_usuario) references usuario (id),
        constraint fk_tipo_lista foreign key (id_tipo_lista) references tipo_lista (id)
    );

create table
    tarefa (
        id int primary key auto_increment,
        nome varchar(100) not null,
        descricao varchar(255) not null,
        dt_inicio timestamp default current_timestamp,
        dt_final datetime,
        duracao int,
        status varchar(20) check (
            status in ('em processo', 'concluída', 'lista vazia')
        )
    );

create table
    lista_tarefa (
        id_lista int not null,
        id_tarefa int not null,
        primary key (id_lista, id_tarefa),
        constraint fk_lista foreign key (id_lista) references lista (id),
        constraint fk_tarefa foreign key (id_tarefa) references tarefa (id)
    );

show tables;

-- inserir tipos de lista
insert into tipo_lista (descricao) values ('pessoal');
insert into tipo_lista (descricao) values ('trabalho');
insert into tipo_lista (descricao) values ('estudo');
insert into tipo_lista (descricao) values ('outros');

INSERT INTO `usuario` (`id`, `nome_usuario`, `email`, `senha`, `dt_criacao_conta`) VALUES
(1, 'Guilherme', 'Gui@example.com', '$2y$10$qtxa9lACNlM4E2xy/aCU4OoDMZiPKBBr8.5uSayIPCKMafXVHYlxG', '2024-10-21 01:49:43'),
(2, 'Isabela', 'Isabela@example.com', '$2y$10$eUHfTEEdhERy2C08xQSY4O.Zw0X08hDlEYSN23VDkQBqaPt8MSIIi', '2024-10-21 01:50:03'),
(3, 'Ryan', 'Ryan@example.com', '$2y$10$hKz20k6FNxHQngjKQ6E2meVxSFJix7GziBnzA3G/b.ri8s8TAfEXK', '2024-10-21 01:50:12');

INSERT INTO `lista` (`id`, `id_usuario`, `nome_lista`, `descricao`, `id_tipo_lista`, `dt_criacao`, `dt_atualizacao`) VALUES
(1, 1, 'Estudando TypeScript', 'Utilizando generics e decorator na prática', 1, '2024-10-21 01:56:46', '2024-10-21 01:56:46'),
(2, 2, 'Microsserviço com GO e Kafka', 'Construindo microsserviços com Golang e Kafka', 2, '2024-10-21 01:58:28', '2024-10-21 02:24:41'),
(3, 3, 'Testes automatizados com selenium', 'Criando testes automatizados com Selenium', 1, '2024-10-21 02:00:07', '2024-10-21 02:00:07');