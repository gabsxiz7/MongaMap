create database bd_mongamap;
use bd_mongamap;
   
    create table tb_usuario (
    cd_usuario int primary key auto_increment,
    nm_usuario varchar(45),
    nm_email varchar(45),
    nr_telefone char(11),
    nm_senha char(15)
    );
   
    create table tb_patente (
    cd_patente int auto_increment primary key,
    nm_patente varchar(14),
    nr_parente int,
    fk_cd_usuario int,
    foreign key (fk_cd_usuario) references tb_usuario (cd_usuario)
    );
   
create table tb_local (
    cd_local int primary key,
    nm_local varchar(45),
    nr_endereco_local int,
    nm_bairro_local varchar(45)
    );
   
    create table tb_comentario (
    cd_comentario int primary key auto_increment,
    ds_comentario varchar(60) ,
fk_cd_usuario int,
    foreign key (fk_cd_usuario) references tb_usuario (cd_usuario),
fk_cd_local int,
    foreign key (fk_cd_local) references tb_local(cd_local)
    );
   
    create table tb_avaliacao (
    cd_avaliacao int primary key,
fk_cd_usuario int,
    foreign key (fk_cd_usuario) references tb_usuario (cd_usuario),
fk_cd_local int,
    foreign key (fk_cd_local) references tb_local (cd_local)
    );
    
	create table tb_arquivos (
    id_arquivo int primary key auto_increment,
    nome varchar(50) not null,
    path varchar(100) not null,
    data_upload datetime default current_timestamp
    );

   create table tb_depoimento (
    id_depoimento int auto_increment primary key,
    nome_usuario varchar(60) not null,
    mensagem text not null,
    data_envio datetime default CURRENT_TIMESTAMP
);
