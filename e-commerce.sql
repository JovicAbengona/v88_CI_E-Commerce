-- MySQL Script generated by MySQL Workbench
-- Mon Apr 12 12:20:44 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema e_commerce
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema e_commerce
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `e_commerce` DEFAULT CHARACTER SET utf8 ;
USE `e_commerce` ;

-- -----------------------------------------------------
-- Table `e_commerce`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `e_commerce`.`products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `description` VARCHAR(255) NULL,
  `price` VARCHAR(45) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `e_commerce`.`carts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `e_commerce`.`carts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `e_commerce`.`billing`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `e_commerce`.`billing` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cart_id` INT NOT NULL,
  `amount` INT NULL,
  `name` VARCHAR(255) NULL,
  `address` VARCHAR(255) NULL,
  `card_number` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_billing_cart_idx` (`cart_id` ASC) VISIBLE,
  CONSTRAINT `fk_billing_cart`
    FOREIGN KEY (`cart_id`)
    REFERENCES `e_commerce`.`carts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `e_commerce`.`cart_details`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `e_commerce`.`cart_details` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cart_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_cart_details_carts1_idx` (`cart_id` ASC) VISIBLE,
  INDEX `fk_cart_details_products1_idx` (`product_id` ASC) VISIBLE,
  CONSTRAINT `fk_cart_details_carts1`
    FOREIGN KEY (`cart_id`)
    REFERENCES `e_commerce`.`carts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cart_details_products1`
    FOREIGN KEY (`product_id`)
    REFERENCES `e_commerce`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;