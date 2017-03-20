-- MySQL Script generated by MySQL Workbench
-- Mon Mar 20 07:26:38 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema db_hotel
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_hotel
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_hotel` DEFAULT CHARACTER SET utf8 ;
USE `db_hotel` ;

-- -----------------------------------------------------
-- Table `db_hotel`.`tb_cidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_hotel`.`tb_cidade` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(120) NULL DEFAULT NULL,
  `estado` INT UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `tb_cidade_FKIndex1` (`estado` ASC));


-- -----------------------------------------------------
-- Table `db_hotel`.`tb_estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_hotel`.`tb_estado` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(60) NULL DEFAULT NULL,
  `uf` VARCHAR(2) NULL DEFAULT NULL,
  `pais` INT UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `tb_estado_FKIndex1` (`pais` ASC));


-- -----------------------------------------------------
-- Table `db_hotel`.`tb_pais`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_hotel`.`tb_pais` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(60) NULL DEFAULT NULL,
  `name` VARCHAR(60) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `db_hotel`.`tb_tipo_documento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_hotel`.`tb_tipo_documento` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `sigla` VARCHAR(10) NULL DEFAULT NULL,
  `nome` VARCHAR(60) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `db_hotel`.`tb_hospede`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_hotel`.`tb_hospede` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NULL DEFAULT NULL,
  `dt_nascimento` DATE NULL DEFAULT NULL,
  `telefone` VARCHAR(45) NULL DEFAULT NULL,
  `profissao` VARCHAR(45) NULL DEFAULT NULL,
  `sexo` CHAR(1) NULL DEFAULT NULL,
  `cidade` INT UNSIGNED NOT NULL,
  `estado` INT UNSIGNED NOT NULL,
  `pais` INT UNSIGNED NOT NULL,
  `cep` INT UNSIGNED NULL DEFAULT NULL,
  `endereco` VARCHAR(255) NULL DEFAULT NULL,
  `tipo_documento` INT UNSIGNED NOT NULL,
  `num_documento` VARCHAR(60) NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tb_hospede_tb_cidade_idx` (`cidade` ASC),
  INDEX `fk_tb_hospede_tb_estado1_idx` (`estado` ASC),
  INDEX `fk_tb_hospede_tb_pais1_idx` (`pais` ASC),
  INDEX `fk_tb_hospede_tb_tipo_documento1_idx` (`tipo_documento` ASC),
  CONSTRAINT `fk_tb_hospede_tb_cidade`
    FOREIGN KEY (`cidade`)
    REFERENCES `db_hotel`.`tb_cidade` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_hospede_tb_estado1`
    FOREIGN KEY (`estado`)
    REFERENCES `db_hotel`.`tb_estado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_hospede_tb_pais1`
    FOREIGN KEY (`pais`)
    REFERENCES `db_hotel`.`tb_pais` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_hospede_tb_tipo_documento1`
    FOREIGN KEY (`tipo_documento`)
    REFERENCES `db_hotel`.`tb_tipo_documento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `db_hotel`.`tb_quarto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_hotel`.`tb_quarto` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `num_quarto` INT UNSIGNED NULL DEFAULT NULL,
  `max_hospede` INT UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `db_hotel`.`tb_motivo_viagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_hotel`.`tb_motivo_viagem` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(80) NULL DEFAULT NULL,
  `description` VARCHAR(80) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `db_hotel`.`tb_meio_transporte`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_hotel`.`tb_meio_transporte` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NULL DEFAULT NULL,
  `description` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `db_hotel`.`tb_hospedagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_hotel`.`tb_hospedagem` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `hospede` INT UNSIGNED NOT NULL,
  `tp_hospede` CHAR(1) NULL COMMENT 'Se o hospede é o responsável pelo quarto.',
  `quarto` INT UNSIGNED NOT NULL,
  `dt_entrada` DATETIME NULL,
  `dt_saida` DATETIME NULL,
  `motivo_viagem` INT UNSIGNED NOT NULL,
  `meio_transporte` INT UNSIGNED NOT NULL,
  `ultima_procedencia_pais` INT UNSIGNED NOT NULL,
  `ultima_procedencia_estado` INT UNSIGNED NOT NULL,
  `ultima_procedencia_cidade` INT UNSIGNED NOT NULL,
  `prox_destino_pais` INT UNSIGNED NOT NULL,
  `prox_destino_estado` INT UNSIGNED NOT NULL,
  `prox_destino_cidade` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tb_hospedagem_tb_hospede1_idx` (`hospede` ASC),
  INDEX `fk_tb_hospedagem_tb_quarto1_idx` (`quarto` ASC),
  INDEX `fk_tb_hospedagem_tb_motivo_viagem1_idx` (`motivo_viagem` ASC),
  INDEX `fk_tb_hospedagem_tb_meio_transporte1_idx` (`meio_transporte` ASC),
  INDEX `fk_tb_hospedagem_tb_cidade1_idx` (`ultima_procedencia_cidade` ASC),
  INDEX `fk_tb_hospedagem_tb_cidade2_idx` (`prox_destino_cidade` ASC),
  INDEX `fk_tb_hospedagem_tb_pais1_idx` (`ultima_procedencia_pais` ASC),
  INDEX `fk_tb_hospedagem_tb_pais2_idx` (`prox_destino_pais` ASC),
  INDEX `fk_tb_hospedagem_tb_estado1_idx` (`ultima_procedencia_estado` ASC),
  INDEX `fk_tb_hospedagem_tb_estado2_idx` (`prox_destino_estado` ASC),
  CONSTRAINT `fk_tb_hospedagem_tb_hospede1`
    FOREIGN KEY (`hospede`)
    REFERENCES `db_hotel`.`tb_hospede` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_hospedagem_tb_quarto1`
    FOREIGN KEY (`quarto`)
    REFERENCES `db_hotel`.`tb_quarto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_hospedagem_tb_motivo_viagem1`
    FOREIGN KEY (`motivo_viagem`)
    REFERENCES `db_hotel`.`tb_motivo_viagem` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_hospedagem_tb_meio_transporte1`
    FOREIGN KEY (`meio_transporte`)
    REFERENCES `db_hotel`.`tb_meio_transporte` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_hospedagem_tb_cidade1`
    FOREIGN KEY (`ultima_procedencia_cidade`)
    REFERENCES `db_hotel`.`tb_cidade` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_hospedagem_tb_cidade2`
    FOREIGN KEY (`prox_destino_cidade`)
    REFERENCES `db_hotel`.`tb_cidade` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_hospedagem_tb_pais1`
    FOREIGN KEY (`ultima_procedencia_pais`)
    REFERENCES `db_hotel`.`tb_pais` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_hospedagem_tb_pais2`
    FOREIGN KEY (`prox_destino_pais`)
    REFERENCES `db_hotel`.`tb_pais` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_hospedagem_tb_estado1`
    FOREIGN KEY (`ultima_procedencia_estado`)
    REFERENCES `db_hotel`.`tb_estado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_hospedagem_tb_estado2`
    FOREIGN KEY (`prox_destino_estado`)
    REFERENCES `db_hotel`.`tb_estado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;