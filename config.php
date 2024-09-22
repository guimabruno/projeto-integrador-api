<?php

    //  criação  de banco de dados e  variáveis de conexão

    const dbDrive = 'mysql';
    const dbHost = 'localhost';
    const dbName = 'easyStats';
    const dbUser = 'root';
    const dbPass = '';


    /*

        // banco de dados para ser criado no xampp


        CREATE DATABASE easyStats;

            

            CREATE TABLE Times (
                idTime INT PRIMARY KEY AUTO_INCREMENT,
                nomeTime VARCHAR(50) NOT NULL,
                titulos INT DEFAULT 0,
                golsAcumulados INT DEFAULT 0,              
                cartoesAmarelosAcumulados INT DEFAULT 0,  
                cartoesVermelhosAcumulados INT DEFAULT 0   
            );

            CREATE TABLE Jogadores (
                idJogador INT PRIMARY KEY AUTO_INCREMENT,
                idTime INT NOT NULL,
                nomeJogador varchar(50) NOT NULL
                idade INT,
                posicao VARCHAR(50) NOT NULL,
                golsAcumulados INT DEFAULT 0,               
                cartoesAmarelosAcumulados INT DEFAULT 0,   
                cartoesVermelhosAcumulados INT DEFAULT 0,  
                FOREIGN KEY (idTime) REFERENCES Times(idTime)
            );

            CREATE TABLE Partida (
                idPartida INT PRIMARY KEY AUTO_INCREMENT,
                idTimeCasa INT,
                idTimeVisitante INT,
                dataPartida DATETIME,
                resultado VARCHAR(50),
                escanteiosCasa INT DEFAULT 0,
                escanteiosVisitante INT DEFAULT 0,
                cartoesAmarelosCasa INT DEFAULT 0,
                cartoesAmarelosVisitante INT DEFAULT 0,
                cartoesVermelhosCasa INT DEFAULT 0,
                cartoesVermelhosVisitante INT DEFAULT 0,
                golsCasa INT DEFAULT 0,
                golsVisitante INT DEFAULT 0,
                penalidadeCasa INT DEFAULT 0,
                penalidadeVisitante INT DEFAULT 0,
                jogadoresGolsCasa VARCHAR(255),           -- IDs dos jogadores que marcaram gols (separados por vírgula)
                jogadoresGolsVisitante VARCHAR(255),       -- IDs dos jogadores que marcaram gols (separados por vírgula)
                jogadoresCartoesAmarelosCasa VARCHAR(255), -- IDs dos jogadores que receberam amarelo (separados por vírgula)
                jogadoresCartoesAmarelosVisitante VARCHAR(255), -- IDs dos jogadores que receberam amarelo (separados por vírgula)
                jogadoresCartoesVermelhosCasa VARCHAR(255), -- IDs dos jogadores que receberam vermelho (separados por vírgula)
                jogadoresCartoesVermelhosVisitante VARCHAR(255), -- IDs dos jogadores que receberam vermelho (separados por vírgula)
                FOREIGN KEY (idTimeCasa) REFERENCES Times(idTime),
                FOREIGN KEY (idTimeVisitante) REFERENCES Times(idTime)
            );



            //criando times e jogadores 

            INSERT INTO times (nomeTime, titulos)
            VALUES 
                ('Unidos da TI', 5),
                ('Desumanos de Humanas', 3),
                ('Exatas mas não tão exato ', 2),
                ('Juntadão da Saúde',1)

                // como as estastiticas de gols e cartões estão configuradas como defaut não precisa inserir no value por padrão sera 0 até que 
                o insert da api atualize 

            INSERT INTO Jogadores (idTime, idade, posicao, nomeJogador)
            VALUES 
                    -- primeiro time
                (1, 25, 'Goleiro', 'João Silva'),
                (1, 30, 'Zagueiro', 'Pedro Santos'),
                (1, 28, 'Zagueiro', 'Lucas Oliveira'),
                (1, 26, 'Zagueiro', 'Thiago Almeida'),
                (1, 27, 'Zagueiro', 'Bruno Costa'),
                (1, 24, 'Meia', 'Gabriel Rocha'),
                (1, 22, 'Meia', 'Rafael Lima'),
                (1, 29, 'Meia', 'Vinícius Ferreira'),
                (1, 23, 'Atacante', 'Matheus Martins'),
                (1, 21, 'Atacante', 'Felipe Cardoso'),
                (1, 31, 'Atacante', 'Eduardo Gomes'),

                -- segundo time
                (2, 26, 'Goleiro', 'André Pereira'),
                (2, 29, 'Zagueiro', 'Carlos Mendes'),
                (2, 24, 'Zagueiro', 'Daniel Araújo'),
                (2, 27, 'Zagueiro', 'Jorge Almeida'),
                (2, 23, 'Zagueiro', 'Diego Martins'),
                (2, 22, 'Meia', 'Bruno Soares'),
                (2, 30, 'Meia', 'Alexandre Ribeiro'),
                (2, 25, 'Meia', 'Robson Silva'),
                (2, 28, 'Atacante', 'Leandro Nascimento'),
                (2, 21, 'Atacante', 'Samuel Torres'),
                (2, 32, 'Atacante', 'Igor Cunha'),

                -- terceiro time
                (3, 27, 'Goleiro', 'Rafael Ferreira'),
                (3, 28, 'Zagueiro', 'Gustavo Mendes'),
                (3, 29, 'Zagueiro', 'Fábio Costa'),
                (3, 30, 'Zagueiro', 'Ricardo Lima'),
                (3, 26, 'Zagueiro', 'Alan Rocha'),
                (3, 25, 'Meia', 'Diego Almeida'),
                (3, 24, 'Meia', 'Roni Silva'),
                (3, 23, 'Meia', 'Thiago Nascimento'),
                (3, 31, 'Atacante', 'João Pedro'),
                (3, 22, 'Atacante', 'Yuri Gomes'),
                (3, 20, 'Atacante', 'Igor Santos'),

                -- quarto  time
                (4, 24, 'Goleiro', 'Bruno Costa'),
                (4, 27, 'Zagueiro', 'Felipe Oliveira'),
                (4, 26, 'Zagueiro', 'Paulo Almeida'),
                (4, 29, 'Zagueiro', 'Vinícius Mendes'),
                (4, 28, 'Zagueiro', 'Edson Nascimento'),
                (4, 30, 'Meia', 'Eduardo Santos'),
                (4, 22, 'Meia', 'Lucas Pereira'),
                (4, 23, 'Meia', 'Matheus Lima'),
                (4, 21, 'Atacante', 'Caio Ferreira'),
                (4, 32, 'Atacante', 'Rodrigo Gomes'),
                (4, 25, 'Atacante', 'André Silva');



    
    */
