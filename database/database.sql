
CREATE DATABASE IF NOT EXISTS bd_cadastro_pet
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE bd_cadastro_pet;

CREATE TABLE IF NOT EXISTS pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    especie VARCHAR(50) NOT NULL,
    raca VARCHAR(100),
    idade INT,
    sexo VARCHAR(20),
    nome_tutor VARCHAR(150) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO pets
(nome, especie, raca, idade, sexo, nome_tutor)
VALUES
('Thor', 'Cachorro', 'Golden Retriever', 3, 'Macho', 'Carlos Silva'),
('Mel', 'Cachorro', 'Shih-tzu', 2, 'Fêmea', 'Ana Souza'),
('Mimi', 'Gato', 'Siamês', 4, 'Fêmea', 'João Santos'),
('Rex', 'Cachorro', 'Pastor Alemão', 5, 'Macho', 'Maria Oliveira');