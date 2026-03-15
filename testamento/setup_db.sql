-- ═══════════════════════════════════════
-- BANCO DE DADOS — Testamentos
-- ═══════════════════════════════════════

CREATE DATABASE IF NOT EXISTS heranca_digital
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE heranca_digital;

CREATE TABLE IF NOT EXISTS testamentos (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  nome            VARCHAR(255)  NOT NULL,
  nacionalidade   VARCHAR(100)  NOT NULL,
  estado_civil    VARCHAR(50)   NOT NULL,
  profissao       VARCHAR(150)  NOT NULL,
  cpf             VARCHAR(20)   NOT NULL,
  rg              VARCHAR(30)   NOT NULL,
  data_nascimento DATE          NOT NULL,
  filiacao        VARCHAR(255)  NOT NULL,
  endereco        TEXT          NOT NULL,
  email           VARCHAR(255)  NOT NULL,
  telefone        VARCHAR(30)   NOT NULL,
  modelo_chave    VARCHAR(50)   NOT NULL,
  modelo_nome     VARCHAR(255)  NOT NULL,
  modalidade      ENUM('particular','cerrado') NOT NULL,
  ip              VARCHAR(45)   DEFAULT NULL,
  criado_em       DATETIME      DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
