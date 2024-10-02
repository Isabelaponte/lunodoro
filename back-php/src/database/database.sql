create database lunodoro;
-- drop database lunodoroRefactor;
use lunodoro;

create table usuario(
    id int primary key auto_increment,
    nome_usuario varchar(100) not null,
    email varchar(100) not null unique,
    senha varchar(255) not null,
    dt_criacao_conta timestamp default current_timestamp
);

create table tipo_lista(
	id int primary key auto_increment,
    descricao varchar(20) not null unique
);

create table lista(
    id int primary key auto_increment,
    id_usuario int not null,
    nome_lista varchar(100) not null,
    descricao varchar(255) not null,
    id_tipo_lista int not null,
    dt_criacao timestamp default current_timestamp,
    dt_atualizacao timestamp default current_timestamp on update current_timestamp,
    constraint fk_usuario foreign key (id_usuario) references usuario(id),
    constraint fk_tipo_lista foreign key (id_tipo_lista) references tipo_lista(id)
);

create table tarefa(
    id int primary key auto_increment,
    nome varchar(100) not null,
    descricao varchar(255) not null,
    dt_inicio timestamp default current_timestamp,
    dt_final datetime,
    duracao int,
    status varchar(20) check(status in ('em processo', 'concluída', 'lista vazia'))
);

create table lista_tarefa(
    id_lista int not null,
    id_tarefa int not null,
    primary key (id_lista, id_tarefa),
    constraint fk_lista foreign key (id_lista) references lista(id),
    constraint fk_tarefa foreign key (id_tarefa) references tarefa(id)
);

show tables;

-- Inserir usuario
insert into usuario (nome_usuario, email, senha) values ('guilherme', 'guilherme@gmail.com', '2456');
insert into usuario (nome_usuario, email, senha) values ('isabela', 'isabela@gmail.com', '1234');
insert into usuario (nome_usuario, email, senha) values ('ryan', 'ryan@gmail.com', 'abcd');

-- inserir tipos de lista
insert into tipo_lista (descricao) values ('pessoal');
insert into tipo_lista (descricao) values ('trabalho');
insert into tipo_lista (descricao) values ('estudo');
insert into tipo_lista (descricao) values ('outros');

-- Inserir listas
insert into lista (id_usuario, nome_lista, descricao, id_tipo_lista) values ((select id from usuario where email = 'guilherme@gmail.com'), 'Lista de Tarefas', 'Tarefas diárias', 1);
insert into lista (id_usuario, nome_lista, descricao, id_tipo_lista) values ((select id from usuario where email = 'guilherme@gmail.com'), 'Nova Lista', 'Tarefas diárias', 1);
insert into lista (id_usuario, nome_lista, descricao, id_tipo_lista) values ((select id from usuario where email = 'isabela@gmail.com'), 'Projetos de Trabalho', 'Projetos em andamento', 2);
insert into lista (id_usuario, nome_lista, descricao, id_tipo_lista) values ((select id from usuario where email = 'ryan@gmail.com'), 'Estudos', 'Materiais de estudo', 3);

-- Inserir tarefas
insert into tarefa (nome, descricao, dt_final, duracao, status) values 
('Comprar mantimentos', 'Comprar frutas e vegetais', '2024-09-10 12:00:00', 120, 'em processo'),
('Reunião com cliente', 'Reunião para discutir requisitos','2024-09-11 15:00:00', 60, 'concluída'),
('Ler capítulo 5', 'Ler o capítulo 5 do livro de matemática','2024-09-12 11:00:00', 120, 'em processo');

-- Inserir relacionamentos entre listas e tarefas
insert into lista_tarefa (id_lista, id_tarefa) values 
((select id from lista where nome_lista = 'Lista de Tarefas' and id_usuario = (select id from usuario where email = 'guilherme@gmail.com')), 
 (select id from tarefa where nome = 'Comprar mantimentos')),
((select id from lista where nome_lista = 'Projetos de Trabalho' and id_usuario = (select id from usuario where email = 'isabela@gmail.com')), 
 (select id from tarefa where nome = 'Reunião com cliente')),
((select id from lista where nome_lista = 'Estudos' and id_usuario = (select id from usuario where email = 'ryan@gmail.com')), 
 (select id from tarefa where nome = 'Ler capítulo 5'));

-- Testes de inserção e validação de dados
select * from usuario;
select * from lista;
select * from tarefa;
select * from lista_tarefa;

-- Se tudo der errado
/*delete from lista_tarefa;
delete from tarefa;
delete from lista;
delete from usuario;*/
