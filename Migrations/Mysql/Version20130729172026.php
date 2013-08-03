<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130729172026 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
			// this up() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_asset (persistence_object_identifier VARCHAR(40) NOT NULL, originalresource VARCHAR(40) DEFAULT NULL, createdate DATETIME NOT NULL, updateddate DATETIME NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, caption VARCHAR(255) NOT NULL, copyright VARCHAR(255) NOT NULL, INDEX IDX_4C3861D4E59BB9C (originalresource), PRIMARY KEY(persistence_object_identifier))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_category (persistence_object_identifier VARCHAR(40) NOT NULL, parentcategory VARCHAR(40) DEFAULT NULL, image VARCHAR(40) DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, createdate DATETIME NOT NULL, hidden TINYINT(1) NOT NULL, updateddate DATETIME NOT NULL, INDEX IDX_1E9D59504C8CFA (parentcategory), INDEX IDX_1E9D5950C53D045F (image), PRIMARY KEY(persistence_object_identifier))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_comment (persistence_object_identifier VARCHAR(40) NOT NULL, news VARCHAR(40) DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, createddate DATETIME NOT NULL, updateddate DATETIME NOT NULL, sethidden TINYINT(1) NOT NULL, INDEX IDX_F273B4BB1DD39950 (news), PRIMARY KEY(persistence_object_identifier))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_file (persistence_object_identifier VARCHAR(40) NOT NULL, originalfileresource VARCHAR(40) DEFAULT NULL, createdate DATETIME NOT NULL, updateddate DATETIME NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, hidden TINYINT(1) NOT NULL, INDEX IDX_56F668553A0DFE84 (originalfileresource), PRIMARY KEY(persistence_object_identifier))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_link (persistence_object_identifier VARCHAR(40) NOT NULL, createdate DATETIME NOT NULL, updateddate DATETIME NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, uri VARCHAR(255) NOT NULL, hidden TINYINT(1) NOT NULL, PRIMARY KEY(persistence_object_identifier))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_news (persistence_object_identifier VARCHAR(40) NOT NULL, createdby VARCHAR(40) DEFAULT NULL, title VARCHAR(255) NOT NULL, subtitle LONGTEXT NOT NULL, alternativetitle VARCHAR(255) NOT NULL, authorname VARCHAR(255) NOT NULL, authoremail VARCHAR(255) NOT NULL, createddate DATETIME NOT NULL, hidden TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, datetime DATETIME NOT NULL, archivedate DATETIME DEFAULT NULL, keywords LONGTEXT NOT NULL, enddate DATETIME NOT NULL, istopnews TINYINT(1) NOT NULL, updateddate DATETIME NOT NULL, INDEX IDX_C7BAC71546D262E0 (createdby), PRIMARY KEY(persistence_object_identifier))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_news_categories_join (news_news VARCHAR(40) NOT NULL, news_category VARCHAR(40) NOT NULL, INDEX IDX_948CC3C0C80E6FDB (news_news), INDEX IDX_948CC3C04F72BA90 (news_category), PRIMARY KEY(news_news, news_category))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_news_tags_join (news_news VARCHAR(40) NOT NULL, news_tag VARCHAR(40) NOT NULL, INDEX IDX_39F79ADDC80E6FDB (news_news), INDEX IDX_39F79ADDBE3ED8A1 (news_tag), PRIMARY KEY(news_news, news_tag))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_news_assets_join (news_news VARCHAR(40) NOT NULL, news_asset VARCHAR(40) NOT NULL, INDEX IDX_97972756C80E6FDB (news_news), INDEX IDX_979727567810DD02 (news_asset), PRIMARY KEY(news_news, news_asset))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_news_files_join (news_news VARCHAR(40) NOT NULL, news_file VARCHAR(40) NOT NULL, INDEX IDX_240954B2C80E6FDB (news_news), INDEX IDX_240954B25942C09B (news_file), PRIMARY KEY(news_news, news_file))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_news_relatedlinks_join (news_news VARCHAR(40) NOT NULL, news_link VARCHAR(40) NOT NULL, INDEX IDX_C84303F6C80E6FDB (news_news), INDEX IDX_C84303F6E3716F7A (news_link), PRIMARY KEY(news_news, news_link))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_news_relatednews_join (news_news VARCHAR(40) NOT NULL, related_news_id VARCHAR(40) NOT NULL, INDEX IDX_F2935800C80E6FDB (news_news), INDEX IDX_F29358008ABD9305 (related_news_id), PRIMARY KEY(news_news, related_news_id))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_tag (persistence_object_identifier VARCHAR(40) NOT NULL, title VARCHAR(255) NOT NULL, createdate DATETIME NOT NULL, updateddate DATETIME NOT NULL, hidden TINYINT(1) NOT NULL, PRIMARY KEY(persistence_object_identifier))  ENGINE = InnoDB");
		$this->addSql("CREATE TABLE lelesys_plugin_news_domain_model_user (persistence_object_identifier VARCHAR(40) NOT NULL, profileimage VARCHAR(40) DEFAULT NULL, gender INT NOT NULL, address VARCHAR(255) NOT NULL, phoneno VARCHAR(255) NOT NULL, createdate DATETIME NOT NULL, updateddate DATETIME NOT NULL, INDEX IDX_57FA880C2ED0FBD0 (profileimage), PRIMARY KEY(persistence_object_identifier))  ENGINE = InnoDB");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_asset ADD CONSTRAINT FK_4C3861D4E59BB9C FOREIGN KEY (originalresource) REFERENCES typo3_flow_resource_resource (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_category ADD CONSTRAINT FK_1E9D59504C8CFA FOREIGN KEY (parentcategory) REFERENCES lelesys_plugin_news_domain_model_category (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_category ADD CONSTRAINT FK_1E9D5950C53D045F FOREIGN KEY (image) REFERENCES typo3_flow_resource_resource (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_comment ADD CONSTRAINT FK_F273B4BB1DD39950 FOREIGN KEY (news) REFERENCES lelesys_plugin_news_domain_model_news (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_file ADD CONSTRAINT FK_56F668553A0DFE84 FOREIGN KEY (originalfileresource) REFERENCES typo3_flow_resource_resource (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news ADD CONSTRAINT FK_C7BAC71546D262E0 FOREIGN KEY (createdby) REFERENCES lelesys_plugin_news_domain_model_user (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_categories_join ADD CONSTRAINT FK_948CC3C0C80E6FDB FOREIGN KEY (news_news) REFERENCES lelesys_plugin_news_domain_model_news (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_categories_join ADD CONSTRAINT FK_948CC3C04F72BA90 FOREIGN KEY (news_category) REFERENCES lelesys_plugin_news_domain_model_category (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_tags_join ADD CONSTRAINT FK_39F79ADDC80E6FDB FOREIGN KEY (news_news) REFERENCES lelesys_plugin_news_domain_model_news (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_tags_join ADD CONSTRAINT FK_39F79ADDBE3ED8A1 FOREIGN KEY (news_tag) REFERENCES lelesys_plugin_news_domain_model_tag (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_assets_join ADD CONSTRAINT FK_97972756C80E6FDB FOREIGN KEY (news_news) REFERENCES lelesys_plugin_news_domain_model_news (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_assets_join ADD CONSTRAINT FK_979727567810DD02 FOREIGN KEY (news_asset) REFERENCES lelesys_plugin_news_domain_model_asset (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_files_join ADD CONSTRAINT FK_240954B2C80E6FDB FOREIGN KEY (news_news) REFERENCES lelesys_plugin_news_domain_model_news (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_files_join ADD CONSTRAINT FK_240954B25942C09B FOREIGN KEY (news_file) REFERENCES lelesys_plugin_news_domain_model_file (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_relatedlinks_join ADD CONSTRAINT FK_C84303F6C80E6FDB FOREIGN KEY (news_news) REFERENCES lelesys_plugin_news_domain_model_news (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_relatedlinks_join ADD CONSTRAINT FK_C84303F6E3716F7A FOREIGN KEY (news_link) REFERENCES lelesys_plugin_news_domain_model_link (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_relatednews_join ADD CONSTRAINT FK_F2935800C80E6FDB FOREIGN KEY (news_news) REFERENCES lelesys_plugin_news_domain_model_news (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_relatednews_join ADD CONSTRAINT FK_F29358008ABD9305 FOREIGN KEY (related_news_id) REFERENCES lelesys_plugin_news_domain_model_news (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_user ADD CONSTRAINT FK_57FA880C2ED0FBD0 FOREIGN KEY (profileimage) REFERENCES typo3_flow_resource_resource (persistence_object_identifier)");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_user ADD CONSTRAINT FK_57FA880C47A46B0A FOREIGN KEY (persistence_object_identifier) REFERENCES typo3_party_domain_model_abstractparty (persistence_object_identifier) ON DELETE CASCADE");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
			// this down() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_assets_join DROP FOREIGN KEY FK_979727567810DD02");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_category DROP FOREIGN KEY FK_1E9D59504C8CFA");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_categories_join DROP FOREIGN KEY FK_948CC3C04F72BA90");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_files_join DROP FOREIGN KEY FK_240954B25942C09B");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_relatedlinks_join DROP FOREIGN KEY FK_C84303F6E3716F7A");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_comment DROP FOREIGN KEY FK_F273B4BB1DD39950");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_categories_join DROP FOREIGN KEY FK_948CC3C0C80E6FDB");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_tags_join DROP FOREIGN KEY FK_39F79ADDC80E6FDB");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_assets_join DROP FOREIGN KEY FK_97972756C80E6FDB");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_files_join DROP FOREIGN KEY FK_240954B2C80E6FDB");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_relatedlinks_join DROP FOREIGN KEY FK_C84303F6C80E6FDB");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_relatednews_join DROP FOREIGN KEY FK_F2935800C80E6FDB");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_relatednews_join DROP FOREIGN KEY FK_F29358008ABD9305");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news_tags_join DROP FOREIGN KEY FK_39F79ADDBE3ED8A1");
		$this->addSql("ALTER TABLE lelesys_plugin_news_domain_model_news DROP FOREIGN KEY FK_C7BAC71546D262E0");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_asset");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_category");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_comment");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_file");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_link");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_news");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_news_categories_join");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_news_tags_join");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_news_assets_join");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_news_files_join");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_news_relatedlinks_join");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_news_relatednews_join");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_tag");
		$this->addSql("DROP TABLE lelesys_plugin_news_domain_model_user");
	}
}

?>