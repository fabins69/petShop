-- Sistema de Gerenciamento de Estoque de Pet Shop
-- MySQL 8.0+ | Execute em um banco de testes vazio.
CREATE DATABASE IF NOT EXISTS petshop
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
USE petshop;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity),
    CONSTRAINT sessions_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE cache (
    `key` VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE cache_locks (
    `key` VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX jobs_queue_index (queue)
) ENGINE=InnoDB;

CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL
) ENGINE=InnoDB;

CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE personal_access_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    abilities TEXT NULL,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX personal_access_tokens_tokenable_type_tokenable_id_index (tokenable_type, tokenable_id)
) ENGINE=InnoDB;

CREATE TABLE categorias (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome_categoria VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE produtos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT NULL,
    marca VARCHAR(100) NOT NULL,
    categoria_id BIGINT UNSIGNED NOT NULL,
    preco_custo DECIMAL(10,2) NOT NULL,
    preco_venda DECIMAL(10,2) NOT NULL,
    qtd_estoque INT UNSIGNED NOT NULL DEFAULT 0,
    estoque_min INT UNSIGNED NOT NULL DEFAULT 0,
    prazo_validade DATE NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX produtos_categoria_id_index (categoria_id),
    INDEX produtos_validade_index (prazo_validade),
    CONSTRAINT produtos_categoria_id_foreign FOREIGN KEY (categoria_id) REFERENCES categorias(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE movimentacoes_estoque (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    produto_id BIGINT UNSIGNED NULL,
    produto_nome VARCHAR(255) NOT NULL,
    user_id BIGINT UNSIGNED NULL,
    tipo ENUM('entrada','saida') NOT NULL,
    quantidade INT UNSIGNED NOT NULL,
    estoque_anterior INT UNSIGNED NOT NULL DEFAULT 0,
    estoque_posterior INT UNSIGNED NOT NULL DEFAULT 0,
    observacao VARCHAR(500) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX movimentacoes_tipo_data_index (tipo, created_at),
    INDEX movimentacoes_produto_data_index (produto_id, created_at),
    CONSTRAINT movimentacoes_produto_id_foreign FOREIGN KEY (produto_id) REFERENCES produtos(id)
        ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT movimentacoes_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- Usuário para demonstração local. Senha em texto para login: 123456789.
-- Troque a senha antes de usar o sistema fora de um ambiente escolar/de teste.
INSERT INTO users (id, name, email, password, created_at, updated_at) VALUES
(1, 'Administrador', 'admin@petshop.com', '$2y$12$Zd.FEtoOQE4rbIyTuN0CyeBL6Hy6Sma7G7LNh/PD9.fZPP40nhoF6', NOW(), NOW());

INSERT INTO categorias (id, nome_categoria, created_at, updated_at) VALUES
(1, 'Rações', NOW(), NOW()),
(2, 'Medicamentos', NOW(), NOW()),
(3, 'Brinquedos', NOW(), NOW()),
(4, 'Higiene', NOW(), NOW()),
(5, 'Acessórios', NOW(), NOW());

INSERT INTO produtos (id, nome, descricao, marca, categoria_id, preco_custo, preco_venda, qtd_estoque, estoque_min, prazo_validade, created_at, updated_at) VALUES
(1, 'Ração Premium para Cães 10 kg', 'Ração completa para cães adultos.', 'NutriPet', 1, 95.00, 129.90, 12, 5, DATE_ADD(CURDATE(), INTERVAL 8 MONTH), NOW(), NOW()),
(2, 'Antipulgas para cães', 'Produto veterinário. Consulte as instruções da embalagem.', 'VetCare', 2, 28.00, 44.90, 2, 4, DATE_ADD(CURDATE(), INTERVAL 5 MONTH), NOW(), NOW()),
(3, 'Bola de borracha', 'Brinquedo resistente para cães.', 'PetPlay', 3, 8.00, 16.90, 20, 6, NULL, NOW(), NOW()),
(4, 'Shampoo para pets 500 ml', 'Shampoo para higiene animal.', 'BanhoBom', 4, 12.00, 22.90, 7, 5, DATE_ADD(CURDATE(), INTERVAL 10 MONTH), NOW(), NOW()),
(5, 'Coleira ajustável', 'Coleira ajustável para cães de pequeno e médio porte.', 'PetFit', 5, 10.00, 24.90, 0, 3, NULL, NOW(), NOW());

INSERT INTO movimentacoes_estoque (produto_id, produto_nome, user_id, tipo, quantidade, estoque_anterior, estoque_posterior, observacao, created_at, updated_at) VALUES
(1, 'Ração Premium para Cães 10 kg', 1, 'entrada', 12, 0, 12, 'Estoque inicial de demonstração', NOW(), NOW()),
(2, 'Antipulgas para cães', 1, 'entrada', 2, 0, 2, 'Estoque inicial de demonstração', NOW(), NOW()),
(3, 'Bola de borracha', 1, 'entrada', 20, 0, 20, 'Estoque inicial de demonstração', NOW(), NOW()),
(4, 'Shampoo para pets 500 ml', 1, 'entrada', 7, 0, 7, 'Estoque inicial de demonstração', NOW(), NOW());
