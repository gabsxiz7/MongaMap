create database mongamap;
use mongamap;
   
    create table tb_usuario (
    cd_usuario int primary key auto_increment,
    nm_usuario varchar(45),
    nm_email varchar(45),
    nr_telefone char(11),
    nm_senha char(255)
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

CREATE TABLE tb_quiz (
    cd_quiz INT AUTO_INCREMENT PRIMARY KEY,
    nm_quiz VARCHAR(100),
    fk_cd_local INT,
    FOREIGN KEY (fk_cd_local) REFERENCES tb_local(cd_local)
);

CREATE TABLE tb_pergunta (
    cd_pergunta INT AUTO_INCREMENT PRIMARY KEY,
    ds_pergunta TEXT,
    ds_resposta_correta VARCHAR(100),
    ds_resposta_errada1 VARCHAR(100),
    ds_resposta_errada2 VARCHAR(100),
    ds_resposta_errada3 VARCHAR(100),
    fk_cd_quiz INT,
    FOREIGN KEY (fk_cd_quiz) REFERENCES tb_quiz(cd_quiz)
);

CREATE TABLE tb_token_redefinicao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cd_usuario INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    data_expiracao DATETIME NOT NULL,
    FOREIGN KEY (cd_usuario) REFERENCES tb_usuario(cd_usuario)
    );
    
    CREATE TABLE tb_depoimento (
    id_depoimento INT AUTO_INCREMENT PRIMARY KEY,
    cd_usuario INT NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cd_usuario) REFERENCES tb_usuario(cd_usuario)
    );