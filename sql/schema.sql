-- =====================================================
-- Cláusula Sólida — Schema da Base de Dados
-- Versão: 1.0
-- Data: 2026-04-30
-- Descrição: Criação da base de dados e tabelas
--            para gestão de contactos/leads.
-- =====================================================

-- Criar a base de dados (se não existir)
CREATE DATABASE IF NOT EXISTS clausula_solida
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE clausula_solida;

-- =====================================================
-- Tabela: contactos
-- Armazena todos os pedidos de contacto recebidos
-- através do formulário do site.
-- =====================================================
CREATE TABLE IF NOT EXISTS contactos (
    id          INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    nome        VARCHAR(100)    NOT NULL COMMENT 'Nome completo do remetente',
    email       VARCHAR(150)    NOT NULL COMMENT 'Endereço de e-mail',
    telefone    VARCHAR(20)     DEFAULT NULL COMMENT 'Número de telefone (opcional)',
    assunto     VARCHAR(200)    DEFAULT NULL COMMENT 'Assunto do contacto',
    mensagem    TEXT            NOT NULL COMMENT 'Corpo da mensagem',
    ip_address  VARCHAR(45)     DEFAULT NULL COMMENT 'IP do remetente (IPv4/IPv6)',
    user_agent  VARCHAR(255)    DEFAULT NULL COMMENT 'Browser do remetente',
    lido        TINYINT(1)      DEFAULT 0 COMMENT 'Mensagem lida: 0=Não, 1=Sim',
    criado_em   TIMESTAMP       DEFAULT CURRENT_TIMESTAMP COMMENT 'Data e hora de criação',

    -- Índices para consultas frequentes
    INDEX idx_email      (email),
    INDEX idx_criado_em  (criado_em),
    INDEX idx_lido       (lido)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Pedidos de contacto recebidos pelo site';

-- =====================================================
-- Tabela: newsletter (opcional, para futura expansão)
-- Armazena subscrições à newsletter.
-- =====================================================
CREATE TABLE IF NOT EXISTS newsletter (
    id          INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    email       VARCHAR(150)    NOT NULL UNIQUE COMMENT 'Endereço de e-mail',
    ativo       TINYINT(1)      DEFAULT 1 COMMENT 'Subscrição ativa: 0=Não, 1=Sim',
    criado_em   TIMESTAMP       DEFAULT CURRENT_TIMESTAMP COMMENT 'Data de subscrição',

    INDEX idx_ativo (ativo)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Subscrições à newsletter';
