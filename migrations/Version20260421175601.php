<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260421175601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, note SMALLINT NOT NULL, commentaire LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, note_nettete SMALLINT DEFAULT NULL, note_emplacement SMALLINT DEFAULT NULL, note_rapport_qualite SMALLINT DEFAULT NULL, reponse_proprietaire LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, est_visible TINYINT NOT NULL, cree_le DATETIME NOT NULL, voyageur_id INT NOT NULL, logement_id INT NOT NULL, reservation_id INT NOT NULL, UNIQUE INDEX UNIQ_8F91ABF0B83297E7 (reservation_id), INDEX IDX_8F91ABF062915402 (voyageur_id), INDEX IDX_8F91ABF058ABF955 (logement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT `FK_8F91ABF058ABF955` FOREIGN KEY (logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT `FK_8F91ABF062915402` FOREIGN KEY (voyageur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT `FK_8F91ABF0B83297E7` FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('CREATE TABLE config_commission (id INT AUTO_INCREMENT NOT NULL, taux NUMERIC(10, 2) NOT NULL, montant_min NUMERIC(10, 2) DEFAULT \'NULL\', montant_max NUMERIC(10, 2) DEFAULT \'NULL\', est_active TINYINT NOT NULL, cree_le DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('CREATE TABLE disponibilite (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, est_disponible TINYINT NOT NULL, prix_personnalise NUMERIC(10, 2) DEFAULT \'NULL\', logement_id INT NOT NULL, INDEX IDX_2CBACE2F58ABF955 (logement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE disponibilite ADD CONSTRAINT `FK_2CBACE2F58ABF955` FOREIGN KEY (logement_id) REFERENCES logement (id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, icone VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, categorie VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('CREATE TABLE equipement_logement (equipement_id INT NOT NULL, logement_id INT NOT NULL, INDEX IDX_EF2C4A73806F0F5C (equipement_id), INDEX IDX_EF2C4A7358ABF955 (logement_id), PRIMARY KEY (equipement_id, logement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE equipement_logement ADD CONSTRAINT `FK_EF2C4A7358ABF955` FOREIGN KEY (logement_id) REFERENCES logement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipement_logement ADD CONSTRAINT `FK_EF2C4A73806F0F5C` FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('CREATE TABLE favori (id INT AUTO_INCREMENT NOT NULL, ajoute_le DATETIME NOT NULL, voyageur_id INT NOT NULL, logement_id INT NOT NULL, INDEX IDX_EF85A2CC62915402 (voyageur_id), INDEX IDX_EF85A2CC58ABF955 (logement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT `FK_EF85A2CC58ABF955` FOREIGN KEY (logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT `FK_EF85A2CC62915402` FOREIGN KEY (voyageur_id) REFERENCES utilisateur (id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('CREATE TABLE logement (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, slug VARCHAR(280) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, statut VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix_par_nuit NUMERIC(10, 2) NOT NULL, devise VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, max_voyageurs SMALLINT NOT NULL, chambres SMALLINT NOT NULL, salles_de_bain SMALLINT NOT NULL, latitude DOUBLE PRECISION DEFAULT \'NULL\', longitude DOUBLE PRECISION DEFAULT \'NULL\', adresse VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, ville VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, region VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, cree_le DATETIME NOT NULL, modifie_le DATETIME DEFAULT \'NULL\', proprietaire_id INT NOT NULL, INDEX IDX_F0FD445776C50E4A (proprietaire_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE logement ADD CONSTRAINT `FK_F0FD445776C50E4A` FOREIGN KEY (proprietaire_id) REFERENCES utilisateur (id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, nom_fichier VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type_mime VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, taille INT DEFAULT NULL, position SMALLINT NOT NULL, type VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, logement_id INT NOT NULL, INDEX IDX_6A2CA10C58ABF955 (logement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT `FK_6A2CA10C58ABF955` FOREIGN KEY (logement_id) REFERENCES logement (id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, montant NUMERIC(10, 2) NOT NULL, devise VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, stripe_intention_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, statut VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, paye_le DATETIME DEFAULT \'NULL\', reservation_id INT NOT NULL, UNIQUE INDEX UNIQ_B1DC7A1EB83297E7 (reservation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT `FK_B1DC7A1EB83297E7` FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, date_arrivee DATE NOT NULL, date_depart DATE NOT NULL, nb_voyageurs SMALLINT NOT NULL, nb_nuits SMALLINT NOT NULL, montant_base NUMERIC(10, 2) NOT NULL, taux_commission NUMERIC(10, 2) NOT NULL, montant_commission NUMERIC(10, 2) NOT NULL, montant_total NUMERIC(10, 2) NOT NULL, devise VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, montant_en_eur NUMERIC(10, 2) DEFAULT \'NULL\', statut VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, cree_le DATETIME NOT NULL, confirme_le DATETIME DEFAULT \'NULL\', annule_le DATETIME DEFAULT \'NULL\', voyageur_id INT NOT NULL, logement_id INT NOT NULL, INDEX IDX_42C8495562915402 (voyageur_id), INDEX IDX_42C8495558ABF955 (logement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT `FK_42C8495558ABF955` FOREIGN KEY (logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT `FK_42C8495562915402` FOREIGN KEY (voyageur_id) REFERENCES utilisateur (id)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, telephone VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, avatar_url VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, langue VARCHAR(5) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, est_verifie TINYINT NOT NULL, compte_stripe_id VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, cree_le DATETIME NOT NULL, modifie_le DATETIME DEFAULT \'NULL\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('DROP TABLE `avis`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('DROP TABLE `config_commission`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('DROP TABLE `disponibilite`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('DROP TABLE `equipement`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('DROP TABLE `equipement_logement`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('DROP TABLE `favori`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('DROP TABLE `logement`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('DROP TABLE `media`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('DROP TABLE `paiement`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('DROP TABLE `reservation`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQLPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQLPlatform'."
        );

        $this->addSql('DROP TABLE `utilisateur`');
    }
}
