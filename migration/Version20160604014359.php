<?php

namespace AjastaMigration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160604014359 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE LineItemReference (position INT NOT NULL, lineItemId BINARY(16) NOT NULL COMMENT \'(DC2Type:Ajasta.LineItem.LineItemId)\', UNIQUE INDEX UNIQ_902D88FFC7E87958 (lineItemId), PRIMARY KEY(position, lineItemId)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Project (active TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL COMMENT \'(DC2Type:Ajasta.Descriptor)\', defaultUnit VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:Ajasta.Unit)\', defaultUnitPrice NUMERIC(10, 2) DEFAULT NULL COMMENT \'(DC2Type:Ajasta.Price)\', projectId BINARY(16) NOT NULL COMMENT \'(DC2Type:Ajasta.Project.ProjectId)\', clientId BINARY(16) NOT NULL COMMENT \'(DC2Type:Ajasta.Client.ClientId)\', INDEX IDX_E00EE972EA1CE9BE (clientId), PRIMARY KEY(projectId)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Invoice (invoiceNumber VARCHAR(255) NOT NULL, locale CHAR(5) NOT NULL COMMENT \'(DC2Type:Ajasta.Locale)\', currencyCode CHAR(3) NOT NULL COMMENT \'(DC2Type:Ajasta.CurrencyCode)\', issueDate DATE NOT NULL COMMENT \'(DC2Type:Ajasta.ImmutableDate)\', dueDate DATE NOT NULL COMMENT \'(DC2Type:Ajasta.ImmutableDate)\', transmissionDate DATE DEFAULT NULL COMMENT \'(DC2Type:Ajasta.ImmutableDate)\', paymentReceiptDate DATE DEFAULT NULL COMMENT \'(DC2Type:Ajasta.ImmutableDate)\', vatPercentage NUMERIC(4, 2) NOT NULL COMMENT \'(DC2Type:Ajasta.VatPercentage)\', invoiceId BINARY(16) NOT NULL COMMENT \'(DC2Type:Ajasta.Invoice.InvoiceId)\', clientId BINARY(16) NOT NULL COMMENT \'(DC2Type:Ajasta.Client.ClientId)\', projectId BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:Ajasta.Project.ProjectId)\', INDEX IDX_5FD82ED8EA1CE9BE (clientId), INDEX IDX_5FD82ED86C9360F7 (projectId), PRIMARY KEY(invoiceId)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE InvoiceToLineItemReference (position INT NOT NULL, invoiceId BINARY(16) NOT NULL COMMENT \'(DC2Type:Ajasta.Invoice.InvoiceId)\', lineItemId BINARY(16) NOT NULL COMMENT \'(DC2Type:Ajasta.LineItem.LineItemId)\', INDEX IDX_FCF5693A3D7BDC51 (invoiceId), UNIQUE INDEX UNIQ_FCF5693AC7E87958 (lineItemId), INDEX IDX_FCF5693AC7E87958462CE4F5 (lineItemId, position), PRIMARY KEY(invoiceId, lineItemId, position)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (username VARCHAR(255) NOT NULL COMMENT \'(DC2Type:Ajasta.User.Username)\', passwordHash VARCHAR(60) NOT NULL COMMENT \'(DC2Type:Ajasta.User.PasswordHash)\', emailAddress VARCHAR(255) NOT NULL COMMENT \'(DC2Type:Ajasta.EmailAddress)\', userId BINARY(16) NOT NULL COMMENT \'(DC2Type:Ajasta.User.UserId)\', PRIMARY KEY(userId)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Client (active TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL COMMENT \'(DC2Type:Ajasta.Descriptor)\', locale CHAR(5) DEFAULT NULL COMMENT \'(DC2Type:Ajasta.Locale)\', currencyCode CHAR(3) DEFAULT NULL COMMENT \'(DC2Type:Ajasta.CurrencyCode)\', taxable TINYINT(1) NOT NULL, defaultUnit VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:Ajasta.Unit)\', defaultUnitPrice NUMERIC(10, 2) DEFAULT NULL COMMENT \'(DC2Type:Ajasta.Price)\', vatPercentage NUMERIC(4, 2) DEFAULT NULL COMMENT \'(DC2Type:Ajasta.VatPercentage)\', clientId BINARY(16) NOT NULL COMMENT \'(DC2Type:Ajasta.Client.ClientId)\', address_recipient VARCHAR(255) DEFAULT NULL, address_organization VARCHAR(255) DEFAULT NULL, address_addressLine1 VARCHAR(255) DEFAULT NULL, address_addressLine2 VARCHAR(255) DEFAULT NULL, address_locality VARCHAR(255) DEFAULT NULL, address_dependentLocality VARCHAR(255) DEFAULT NULL, address_administrativeArea VARCHAR(255) DEFAULT NULL, address_postalCode VARCHAR(255) DEFAULT NULL, address_sortingCode VARCHAR(255) DEFAULT NULL, address_countryCode VARCHAR(255) NOT NULL, PRIMARY KEY(clientId)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE LineItem (description VARCHAR(255) NOT NULL COMMENT \'(DC2Type:Ajasta.Descriptor)\', quantity INT UNSIGNED NOT NULL COMMENT \'(DC2Type:Ajasta.LineItem.Quantity)\', unit VARCHAR(255) NOT NULL COMMENT \'(DC2Type:Ajasta.Unit)\', unitPrice NUMERIC(10, 2) NOT NULL COMMENT \'(DC2Type:Ajasta.Price)\', lineItemId BINARY(16) NOT NULL COMMENT \'(DC2Type:Ajasta.LineItem.LineItemId)\', PRIMARY KEY(lineItemId)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE LineItemReference ADD CONSTRAINT FK_902D88FFC7E87958 FOREIGN KEY (lineItemId) REFERENCES LineItem (lineItemId)');
        $this->addSql('ALTER TABLE Project ADD CONSTRAINT FK_E00EE972EA1CE9BE FOREIGN KEY (clientId) REFERENCES Client (clientId)');
        $this->addSql('ALTER TABLE Invoice ADD CONSTRAINT FK_5FD82ED8EA1CE9BE FOREIGN KEY (clientId) REFERENCES Client (clientId)');
        $this->addSql('ALTER TABLE Invoice ADD CONSTRAINT FK_5FD82ED86C9360F7 FOREIGN KEY (projectId) REFERENCES Project (projectId)');
        $this->addSql('ALTER TABLE InvoiceToLineItemReference ADD CONSTRAINT FK_FCF5693A3D7BDC51 FOREIGN KEY (invoiceId) REFERENCES Invoice (invoiceId)');
        $this->addSql('ALTER TABLE InvoiceToLineItemReference ADD CONSTRAINT FK_FCF5693AC7E87958462CE4F5 FOREIGN KEY (lineItemId, position) REFERENCES LineItemReference (lineItemId, position)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE InvoiceToLineItemReference DROP FOREIGN KEY FK_FCF5693AC7E87958462CE4F5');
        $this->addSql('ALTER TABLE Invoice DROP FOREIGN KEY FK_5FD82ED86C9360F7');
        $this->addSql('ALTER TABLE InvoiceToLineItemReference DROP FOREIGN KEY FK_FCF5693A3D7BDC51');
        $this->addSql('ALTER TABLE Project DROP FOREIGN KEY FK_E00EE972EA1CE9BE');
        $this->addSql('ALTER TABLE Invoice DROP FOREIGN KEY FK_5FD82ED8EA1CE9BE');
        $this->addSql('ALTER TABLE LineItemReference DROP FOREIGN KEY FK_902D88FFC7E87958');
        $this->addSql('DROP TABLE LineItemReference');
        $this->addSql('DROP TABLE Project');
        $this->addSql('DROP TABLE Invoice');
        $this->addSql('DROP TABLE InvoiceToLineItemReference');
        $this->addSql('DROP TABLE User');
        $this->addSql('DROP TABLE Client');
        $this->addSql('DROP TABLE LineItem');
    }
}
