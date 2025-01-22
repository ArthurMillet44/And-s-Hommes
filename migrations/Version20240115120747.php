<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240115120747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, id_produit INT NOT NULL, mess VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE code_promo (id INT AUTO_INCREMENT NOT NULL, pourcentage INT NOT NULL, nbr_use VARCHAR(255) NOT NULL, nom_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, id_produit INT NOT NULL, date DATETIME NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite INT NOT NULL, nom_produit VARCHAR(255) NOT NULL, INDEX IDX_6EEAA67DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, produit_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_24CC0DF2A76ED395 (user_id), INDEX IDX_24CC0DF2F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite INT NOT NULL, categorie VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, sous_categorie VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_B6BD307FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, surname VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, date_of_birth DATE NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE code_promo MODIFY COLUMN nbr_use INT;');

        $this->addSql('INSERT INTO code_promo (pourcentage,nbr_use,nom_code) VALUES(10,5,"V4apNqz5")');
        $this->addSql('INSERT INTO code_promo (pourcentage,nbr_use,nom_code) VALUES(20,10,"rJp3f7cH")');
        $this->addSql('INSERT INTO code_promo (pourcentage,nbr_use,nom_code) VALUES(30,7,"Yb2tWrSt")');
        $this->addSql('INSERT INTO code_promo (pourcentage,nbr_use,nom_code) VALUES(50,8,"AssU486N")');
        $this->addSql('INSERT INTO code_promo (pourcentage,nbr_use,nom_code) VALUES(90,2,"LEJSdYEK")');
        $this->addSql('INSERT INTO code_promo (pourcentage,nbr_use,nom_code) VALUES(5,100,"8rQuYVWL")');

        //Le produit "rien" ne sera jamais utilisé en tant que produit. Il nous permet uniquement de initialiser la table produit qui
        $this->addSql('INSERT INTO produit (id,nom,prix,quantite,description,categorie,sous_categorie,image) VALUES (0,"rien",0.0,99999,"sert à init","rien","rien","image.jpg")');

        // modification de la quantité :

        $this->addSql('update produit set quantite = 99999;');

        //Insertion de donnée dans la table Produit.


        //SOIN VISAGE

        //- CREME
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Polydratante",29.99,45,"À l’aide d’un procédé chimique révolutionnaire inventé par nos experts, nous avons réussi à synthétiser les 3 principaux besoins des hommes en une seule crème : Peaulhydratante. 
                                    Nous avons fait en sorte de prendre en compte les différents type de peaux avec de légères modifications dans notre recette.Cette et majoritairement composée de produits respectueux de l’environnement et de votre peau.",
                                    "Soins Visage","Crèmes","Polhydratante.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Crème Anti-Âge",19.99,70,"Découvrez le secret de la jeunesse éternelle avec notre crème anti-âge révolutionnaire. Formulée avec des ingrédients de pointe, cette crème luxueuse offre une hydratation intense tout en réduisant visiblement les signes du vieillissement. Sa texture légère pénètre rapidement, laissant votre peau douce, ferme et éclatante.",
                                    "Soins Visage","Crèmes","Crème2.jpg")');
        //- GOMMAGE
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Sérum exfoliant",19.99,23,"Notre sérum va vous permettre de revigorer votre peau en éliminant toutes les cellules mortes. Votre visage renaîtra de ses cendres et laissera ressortir votre beauté au naturel. Peux s’utiliser sur tous types de peaux.",
                                    "Soins Visage","Gommage","serumExfoliant.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Sérum exfoliant peaux abimées",24.49,12,"Révélez la véritable splendeur de votre peau avec notre sérum exfoliant conçu exclusivement pour les peaux les plus abîmées. Cette formule avancée offre une exfoliation douce mais puissante, éliminant délicatement les cellules mortes de la peau pour révéler une nouvelle luminosité. Infusé avec des ingrédients réparateurs, ce sérum agit en profondeur pour restaurer et revitaliser les peaux endommagées.",
                                    "Soins Visage","Gommage","exfoliantPeauAbime.jpg")');

        //- MASQUE
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Masque pour le visage peau pâle",14.99,24,"Réveillez la puissance de votre charisme avec notre masque de soin visage ultime, conçu spécialement pour les hommes soucieux de leur apparence. Notre masque tout-en-un s\'adapte à tous les types de peaux pâle, offrant une expérience de soin exceptionnelle. Libérez-vous du stress quotidien en vous offrant un moment de détente avec ce masque puissant. Enrichi en ingrédients de qualité, il hydrate en profondeur, élimine les impuretés et revitalise la peau pour une apparence dynamique et énergique.",
                                    "Soins Visage","Masque","masquePeauPale.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Masque pour le visage peau mate",14.99,30,"Expérimentez l\'authentique sensation de confiance avec notre masque de soin visage spécifiquement élaboré pour les hommes à la peau mate. Cette formule exceptionnelle s\'adapte harmonieusement à tous les types de peaux mates, procurant une expérience de soin inégalée. Ce masque devient rapidement un indispensable pour tout homme désirant préserver la fraîcheur de sa peau. Embrassez notre masque de soin visage et transformez chaque journée en une déclaration affirmée de votre charme naturel.",
                                    "Soins Visage","Masque","masquePeauMate.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Masque pour le visage adolescent",14.99,20,"Découvrez la voie vers une confiance éclatante avec notre masque de soin visage spécialement conçu pour les adolescents aux prises avec l\'acné. Formulé avec soin, ce masque offre une expérience de soin sur mesure pour les peaux adolescentes sujettes à l\'acné. Sa texture légère et son application facile en font l\'allié idéal pour les adolescents soucieux de préserver la fraîcheur de leur peau.",
                                    "Soins Visage","Masque","masqueAdo.jpg")');

        //BARBE

        //- HUILE BARBE

        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Huile pour barbe brune",14.99,32,"Découvrez notre huile pour barbe brune exquise, spécialement formulée pour nourrir et adoucir les poils tout en laissant une agréable fragrance boisée. Offrez à votre barbe le soin qu\'elle mérite, avec une formule riche en ingrédients naturels pour une apparence soignée et irrésistible. Éveillez vos sens avec notre huile de barbe brune, l\'essentiel pour un style impeccable.",
                                    "Barbe","Huile Barbe","huileBarbeBrune.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Huile pour barbe rousse",14.99,26,"Explorez notre huile pour barbe rousse, une potion enchanteresse qui célèbre la beauté naturelle des barbes rousses. Infusée d\'ingrédients bienfaisants, notre formule apporte une douceur veloutée à vos poils tout en diffusant une délicate fragrance épicée. Donnez à votre barbe rousse une attention particulière, révélant un éclat vibrant et une texture soyeuse. Optez pour l\'excellence avec notre huile de barbe dédiée aux tons roux, pour une allure captivante au quotidien.",
                                    "Barbe","Huile Barbe","huileBarbeRousse.jpg")');

        //- MOUSSE A RASER
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Mousse à raser",14.99,54,"Découvrez l\'élégance ultime de notre mousse à raser, une symphonie sensorielle qui allie la douceur d\'un rasage impeccable à une fragrance envoûtante. Notre formule avancée garantit un rasage sans aucune trace, laissant votre peau douce et apaisée. Plongez dans l\'expérience luxueuse d\'une mousse qui sublime chaque rasage, enveloppant vos sens dans un parfum raffiné. Faites de chaque rasage un rituel empreint de fraîcheur et d\'élégance avec notre mousse à raser d\'exception.",
                                    "Barbe","Mousse à raser","mousseAraser.jpg")');

        //- SHAMPOING BARBE
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Shampoing pour barbe parfum Foret",14.99,21,"Plongez dans l\'excellence de notre shampoing universel pour barbe, une fusion sublime d\'ingrédients naturels qui nourrit, renforce et revitalise toutes les nuances de barbe. Cette formule polyvalente offre une expérience de soins luxueuse, laissant votre barbe impeccablement propre, douce et délicieusement parfumée. Faites de chaque jour un hommage à votre barbe, quelle que soit sa couleur, avec notre shampoing conçu pour magnifier la beauté de chaque poil.",
                                    "Barbe","Shampoing Barbe","shampoingBarbeForet.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Shampoing pour barbe parfum Noisette",19.99,30,"Explorez l\'excellence de notre shampoing polyvalent pour barbe, une synergie exquise d\'ingrédients naturels qui revitalise, fortifie et sublime toutes les nuances de barbe. Plongez dans une expérience de soins de première classe, laissant votre barbe irrésistiblement fraîche, soyeuse et subtilement parfumée. Faites de chaque instant une célébration de votre barbe, indépendamment de sa teinte, grâce à notre shampoing méticuleusement conçu pour magnifier la beauté unique de chaque poil.",
                                    "Barbe","Shampoing Barbe","shampoingBarbeNoisette.jpg")');

        //- LOT BARBE
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Lot produits pour la barbe(peigne offert)",39.99,10,"Explorez l\'ensemble ultime de soins pour barbe, où la sophistication rencontre la qualité. Notre lot exclusif comprend une mousse à raser offrant un rasage impeccable, une huile pour barbe au choix pour une hydratation luxueuse, et un shampoing au choix pour une barbe éclatante. En prime, recevez un peigne pour barbe, l\'accessoire parfait pour sculpter votre style. Offrez-vous le rituel complet, où chaque produit est soigneusement élaboré pour sublimer votre routine de soins. Transformez votre expérience de soins pour barbe avec cet ensemble exceptionnel, une ode au raffinement masculin.",
                                    "Barbe","Lot Barbe","LotBarbePeigne.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Lot produits pour la barbe(rasoir offert)",44.99,10,"Explorez notre ensemble de soins pour barbe d\'exception, alliant sophistication et qualité inégalées. Plongez dans un rituel de rasage impeccable avec notre mousse à raser, hydratez votre barbe avec l\'élégance d\'une huile au choix, et sublimez chaque poil avec notre shampoing premium. En cadeau, recevez un rasoir électrique, fusionnant la praticité moderne avec l\'art du rasage. Chaque produit de cet ensemble incarne l\'excellence, créant une expérience complète de soins pour une barbe irréprochable. Faites de votre routine de soins un moment de luxe avec cet ensemble incomparable.",
                                    "Barbe","Lot Barbe","LotBarbeRasoir.jpg")');

        //PRODUITS CHEVEUX

        //- SHAMPOINGS

        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Shampoing anti-pellicule",11.99,25,"Découvrez notre shampoing anti-pelliculaire pour homme, une formule robuste alliant la lutte efficace contre les pellicules à une fragrance virile et énergique. Conçu pour une utilisation quotidienne, ce shampoing puissant élimine les pellicules tout en préservant la santé de vos cheveux. Profitez d\'une fraîcheur durable et d\'une protection anti-pelliculaire pendant chaque lavage. Notre formule sans compromis est infusée d\'un parfum viril, créant une expérience olfactive distinctive qui complète votre routine de soins capillaires. Libérez-vous des pellicules avec confiance, tout en adoptant une fragrance qui incarne la force et la vitalité.",
                                    "Produit Cheveux","Shampoing","shampoingPellicule.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Shampoing Revitalisant",11.99,20,"Découvrez notre shampoing pour homme, une formule enrichie qui va au-delà du nettoyage quotidien pour offrir des bienfaits revitalisants à votre cuir chevelu. Conçu pour apporter une hydratation essentielle, notre shampoing assure une fraîcheur durable tout en préservant l\'équilibre naturel de votre peau. Profitez d\'une expérience de soins capillaires complète, procurant des bienfaits visibles pour une chevelure saine et éclatante.",
                                    "Produit Cheveux","Shampoing","shampoingRevitalisant.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Shampoing Fraicheur",11.99,20,"Plongez dans l\'univers de notre shampoing homme, une formule sophistiquée qui transcende le simple lavage pour prodiguer à votre cuir chevelu une expérience revitalisante. Conçu pour offrir une hydratation essentielle, notre shampoing procure une fraîcheur durable tout en préservant l\'équilibre naturel de votre peau. Profitez d\'une routine de soins capillaires complète, révélant des bienfaits visibles pour une chevelure saine et pleine de vitalité.",
                                    "Produit Cheveux","Shampoing","ShampoingFraicheur.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Shampoing au charbon",14.99,30,"Explorez notre shampoing conçu pour une utilisation optimale sur cheveux humides, une formule rafraîchissante qui transcende le simple nettoyage pour revitaliser votre cuir chevelu à chaque lavage. Enrichi d\'une hydratation essentielle, notre shampoing assure une fraîcheur persistante tout en préservant l\'équilibre naturel de votre peau, idéalement adapté aux cheveux mouillés.",
                                    "Produit Cheveux","Shampoing","ShampoingCharbon.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Shampoing sec",14.99,28,"Explorez notre shampoing exclusivement conçu pour les cheveux secs, une formule nourrissante qui va bien au-delà du simple nettoyage pour redonner vie à votre cuir chevelu à chaque lavage. Infusé d\'une hydratation essentielle, notre shampoing offre une fraîcheur durable tout en préservant l\'équilibre naturel de votre peau, idéal pour une utilisation sur cheveux secs. Embarquez dans une routine de soins capillaires complète, révélant des bienfaits visibles pour une chevelure saine et rayonnante, même dans les conditions de sécheresse.",
                                    "Produit Cheveux","Shampoing","ShampoingSec.jpg")');

        //- GEL CIRE LAQUE
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Gel Effet Humide",5.99,50,"Explorez notre gel coiffant respectueux de l\'environnement, une formule novatrice qui offre une fixation optimale tout en laissant un effet humide élégant sur vos cheveux. Conçu avec des ingrédients respectueux de l\'environnement, notre gel vous permet de styliser vos cheveux avec confiance, tout en contribuant à la préservation de notre planète. Profitez d\'une tenue longue durée et d\'une brillance naturelle, créant une coiffure impeccable sans compromettre votre engagement envers la durabilité.",
                                    "Produit Cheveux","Gel","Gel.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Cire effet Souple",7.99,29,"Explorez notre cire coiffante respectueuse de l\'environnement, une formulation avant-gardiste qui assure une tenue parfaite tout en conférant un effet naturellement souple à vos cheveux. Élaborée avec des ingrédients écologiques, notre cire offre une manière fluide de sculpter votre coiffure, tout en s\'engageant à préserver notre planète. Profitez d\'une souplesse totale dans le stylisme de vos cheveux, associée à une tenue longue durée et à une texture d\'une douceur exquise.",
                                    "Produit Cheveux","Cire","cire.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Laque Naturel",9.99,19,"Explorez notre laque haute performance, une formulation d\'exception qui élève votre coiffure à un niveau professionnel tout en respectant l\'environnement. Conçue pour offrir un maintien supérieur, notre laque crée une finition impeccable et durable pour toutes vos coiffures. Infusée avec des ingrédients respectueux de l\'environnement, notre laque combine la puissance de fixation professionnelle avec la conscience écologique. Profitez d\'un contrôle optimal, d\'une brillance intense et d\'une tenue qui résiste même aux journées les plus exigeantes.",
                                    "Produit Cheveux","Laque","laque.jpg")');


        //- Couleurs
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Coloration Blonde",9.99,26,"Explorez l\'éclat sublime avec notre coloration blonde pour homme, une innovation capillaire qui transforme votre style avec une élégance audacieuse. Conçue spécifiquement pour les hommes, cette coloration offre une teinte blonde naturelle et sophistiquée, rehaussant votre apparence avec une luminosité incomparable. Notre formule avancée garantit une couleur homogène et éclatante, tout en préservant la santé de vos cheveux. Optez pour un style blond emblématique, exprimant votre confiance avec chaque mèche.",
                                    "Produit Cheveux","Couleur","CouleurBlonde.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Coloration Châtain",9.99,20,"Découvrez une nuance raffinée avec notre coloration châtain pour homme, une révélation capillaire qui insuffle une aura de mystère et d\'élégance à votre style. Spécialement formulée pour les hommes, cette coloration châtain offre une teinte naturelle et nuancée, accentuant subtilement votre apparence avec une sophistication discrète. Notre formule avancée garantit une couleur châtain riche et homogène, tout en préservant la vitalité de vos cheveux. Optez pour un style châtain distingué, exprimant votre personnalité avec chaque nuance.",
                                    "Produit Cheveux","Couleur","CouleurChatain.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Coloration Noir",9.99,19,"Plongez dans l\'intensité avec notre coloration brune pour homme, une expérience capillaire qui évoque la force et la confiance. Spécialement conçue pour les hommes, cette coloration brune offre une teinte profonde et captivante, apportant une dimension supplémentaire à votre style. Notre formule innovante assure une couleur brune vibrante et uniforme, tout en préservant la santé de vos cheveux. Optez pour une allure brune empreinte d\'assurance, exprimant votre charisme avec chaque mèche.",
                                    "Produit Cheveux","Couleur","CouleurNoir.jpg")');



        //PARFUM

        //- PARFUM
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Parfum Homme Natural",54.99,30,"Découvrez notre parfum pour homme, une symphonie olfactive qui incarne l\'essence de la virilité moderne. Des notes raffinées captivent vos sens, évoquant la fraîcheur et la profondeur dans un accord parfait. Plongez dans l\'élégance intemporelle de notre fragrance, une signature olfactive qui laisse une empreinte mémorable. Optez pour l\'exclusivité et l\'authenticité avec notre parfum pour homme, l\'accessoire olfactif ultime pour exprimer votre style distinctif.",
                                    "Parfum","Parfum","parfumNatural.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Parfum Homme Vegetal",59.99,27,"Explorez notre parfum pour homme, une composition olfactive captivante qui célèbre la fraîcheur des notes fruitées avec une sophistication moderne. Plongez dans une expérience sensorielle où des accords fruités subtils se mêlent harmonieusement, créant une fragrance dynamique et énergique. Laissez-vous emporter par l\'essence vibrante de notre parfum, une expression olfactive qui révèle la personnalité unique de l\'homme moderne. Optez pour une touche de fraîcheur fruitée avec notre parfum, l\'accessoire olfactif qui complète votre style avec une élégance audacieuse.",
                                    "Parfum","Parfum","parfumVegetal.jpg")');


        //- DEODORANT
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Déodorant Sauvage",14.99,16,"Explorez notre déodorant pour homme, une explosion audacieuse de notes sauvages qui allie puissance et raffinement. Profitez d\'une protection fiable pendant 72 heures, offrant une fraîcheur intense à chaque instant. Notre formule sans alcool garantit une efficacité durable tout en respectant la sensibilité de votre peau. Laissez-vous emporter par la sauvagerie envoûtante de notre déodorant, l\'essentiel pour affirmer votre présence avec une confiance inébranlable. Exprimez votre côté intrépide avec une signature olfactive qui défie les conventions, tout en assurant une fraîcheur qui perdure.",
                                    "Parfum","Deodorant","DeodorantSauvage.jpg")');
        $this->addSql('INSERT INTO produit (nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Déodorant Végétal",14.99,18,"Découvrez notre déodorant pour homme, une explosion rafraîchissante de notes fruitées qui allie style et performance. Appréciez une protection longue durée de 72 heures, sans compromis sur la fraîcheur. Notre formule innovante, sans alcool, offre une efficacité optimale tout en préservant la délicatesse de votre peau. Laissez-vous envelopper par la fraîcheur persistante de notre déodorant, l\'allié idéal pour une confiance inébranlable tout au long de la journée. Exprimez votre vitalité avec un geste simple et parfumé qui perdure.",
                                    "Parfum","Deodorant","DeodorantVegetal.jpg")');

        //- LOTS
        $this->addSql('INSERT INTO produit(nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Lot parfum et déodorant sauvage",69.99,10,"Éveillez vos sens avec ce lot envoûtant, associant un parfum exquis et un déodorant rafraîchissant. Laissez-vous transporter par des notes captivantes tout au long de la journée, tandis que la protection longue durée du déodorant vous assure une confiance inébranlable. Offrez-vous l\'harmonie parfaite entre élégance olfactive et fraîcheur irrésistible avec ce duo parfumé qui sublime chaque instant.",
                                    "Parfum","Lot","LotParfumDeoSauvage.jpg")');
        $this->addSql('INSERT INTO produit(nom,prix,quantite,description,categorie,sous_categorie,image) VALUES ("Lot de 2 parfums naturels",74.99,10,"Explorez l\'art de la séduction avec ce lot exclusif mariant un parfum envoûtant et un déodorant aux accents subtils. Plongez dans une expérience sensorielle unique où les notes enivrantes du parfum se marient harmonieusement à la fraîcheur durable du déodorant, créant une aura irrésistible qui vous accompagnera tout au long de la journée. Laissez-vous emporter dans un monde de charme et de confiance avec ce tandem parfait pour celles et ceux qui aspirent à la sophistication quotidienne.",
                                    "Parfum","Lot","Lot2ParfumNat.jpg")');



        // PROCEDURES

        // Procédure Ajouter au panier. Cette procédure va permettre d'ajouter au panier.

        $this->addSql('CREATE or replace PROCEDURE AjouterAuPanier (
    IN p_id_user int,
    IN p_id_produit int
)
BEGIN
    INSERT INTO panier (user_id, produit_id, quantite) VALUES (p_id_user, p_id_produit, 1);
END;');

        //Procédure Augmenter quantité Panier

        $this->addSql('CREATE OR REPLACE PROCEDURE AugmenterQuantitePanier (
    IN p_id_panier INT
)
BEGIN
    DECLARE id_user INT;
    DECLARE id_produit INT;
    DECLARE panier_quantite INT;
    DECLARE produit_quantite INT;


SELECT panier.user_id, panier.produit_id, panier.quantite INTO id_user, id_produit, panier_quantite
    FROM panier
    WHERE panier.id= p_id_panier
    LIMIT 1; 


SELECT quantite INTO produit_quantite
    FROM produit
    WHERE produit.id = id_produit
    LIMIT 1; 

    IF id_user IS NOT NULL AND id_produit IS NOT NULL THEN

IF panier_quantite < produit_quantite THEN
            

UPDATE panier SET quantite = quantite + 1 WHERE panier.id= p_id_panier;
        ELSE
            UPDATE panier SET quantite = quantite + 0 WHERE panier.id= p_id_panier;
        END IF;
    ELSE
        SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Lid_panier spécifié nexiste pas";
    END IF; 
END;');

        //Procédure Baisser quantité Panier

        $this->addSql('CREATE OR REPLACE PROCEDURE BaisserQuantitePanier (
    IN p_id_panier INT
)
BEGIN
    DECLARE id_user INT;
    DECLARE id_produit INT;
    DECLARE panier_quantite INT;

    -- Sélectionner id_user, id_produit et quantite du panier en utilisant la clause SET
    SELECT p.user_id, p.produit_id, p.quantite INTO id_user, id_produit, panier_quantite
    FROM panier p
    WHERE p.id= p_id_panier
    LIMIT 1; -- Evite le retournement de plusieurs ligne ce qui poserait problème dans notre cas

    IF id_user IS NOT NULL AND id_produit IS NOT NULL THEN
        IF panier_quantite > 1 THEN
            -- Si la quantité est supérieure à 1, décrémenter la quantité dans le panier
            UPDATE panier SET quantite = quantite - 1 WHERE id= p_id_panier;
        ELSE
            -- Si la quantité est égale à 1, supprimer la ligne du panier
            DELETE FROM panier WHERE id= p_id_panier;
        END IF;
    ELSE
        SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "L\'id_panier spécifié n\'existe pas";
    END IF;
END;');


        //Delete une ligne(Produit) du panier

        $this->addSql('CREATE OR REPLACE PROCEDURE SupprimerLignePanierParId (
    IN p_id_produit INT,    
    IN p_id_user INT
)
BEGIN
    DECLARE id_panier INT;
    SELECT id into id_panier from panier where user_id = p_id_user and produit_id = p_id_produit;
    -- Supprimer la ligne du panier en utilisant l\'id du panier
    DELETE FROM panier WHERE  id = id_panier;
END;');

        //Creer Code promo

        $this->addSql('CREATE OR REPLACE PROCEDURE CreerNouveauCodePromo (
    IN p_pourcentage INT,
    IN p_nombre_utilisation INT,
    IN p_nom_code VARCHAR(255)
)
BEGIN
    -- Insérer un nouveau code promo dans la table code_promo
    INSERT INTO code_promo (pourcentage, nbr_use, nom_code)
    VALUES (p_pourcentage, p_nombre_utilisation, p_nom_code);
END;');

        //Procédure Modifier Code promo

        $this->addSql('CREATE OR REPLACE PROCEDURE MettreAJourCodePromo (
    IN p_id_code INT,
    IN p_pourcentage INT,
    IN p_nombre_utilisation INT,
    IN p_nom_code VARCHAR(255)
)
BEGIN
    -- Vérifier si le code promo avec l\'ID spécifié existe
    DECLARE code_count INT;
    SELECT COUNT(*) INTO code_count FROM code_promo WHERE id= p_id_code;

    IF code_count > 0 THEN
    -- Mettre à jour les informations du code promo
        UPDATE code_promo
        SET pourcentage = p_pourcentage,
            nbr_use= p_nombre_utilisation,
            nom_code = p_nom_code
        WHERE id= p_id_code;
    ELSE
        SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Le code promo avec l\'ID spécifié n\'existe pas";
    END IF;
END;');

        //Procédure Delete Code promo

        $this->addSql('CREATE OR REPLACE PROCEDURE SupprimerCodePromo (
    IN p_id_code INT
)
BEGIN
    -- Vérifier si le code promo avec l\'ID spécifié existe
    DECLARE code_count INT;
    SELECT COUNT(*) INTO code_count FROM code_promo WHERE id= p_id_code;

    IF code_count > 0 THEN
    -- Supprimer le code promo de la table
        DELETE FROM code_promo WHERE id= p_id_code;
    ELSE
        SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Le code promo avec l\ID spécifié n\existe pas";
    END IF;
END;');

        //Creer New Produit

        $this->addSql('CREATE OR REPLACE PROCEDURE CreerNouveauProduit (
    IN p_nom VARCHAR(255),
    IN p_prix FLOAT,
    IN p_quantite INT,
    IN p_description VARCHAR(3000),
    IN p_categorie VARCHAR(50),
    IN p_sous_categorie VARCHAR(50),
    IN p_image VARCHAR(100)
)
BEGIN
    -- Insérer le nouveau produit dans la table produit
    INSERT INTO produit (nom, prix, quantite, description, categorie, sous_categorie, image)
    VALUES (p_nom, p_prix, p_quantite, p_description, p_categorie, p_sous_categorie, p_image);
END;');

        //Procédure Modifier Produit

        $this->addSql('CREATE OR REPLACE PROCEDURE ModifierProduit (
    IN p_id_produit INT,
    IN p_nom VARCHAR(255),
    IN p_prix FLOAT,
    IN p_quantite INT,
    IN p_description VARCHAR(3000),
    IN p_categorie VARCHAR(50),
    IN p_sous_categorie VARCHAR(50),
    IN p_image VARCHAR(100)
)
BEGIN
    -- Vérifier si le produit avec l\'ID spécifié existe
    DECLARE produit_count INT;
    SELECT COUNT(*) INTO produit_count FROM produit WHERE id= p_id_produit;

    IF produit_count > 0 THEN
    -- Mettre à jour les informations du produit
        UPDATE produit
        SET nom = p_nom,
            prix = p_prix,
            quantite = p_quantite,
            description = p_description,
            categorie = p_categorie,
            sous_categorie = p_sous_categorie,
            image = p_image
        WHERE id= p_id_produit;
    ELSE
        SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Le produit avec l\'ID spécifié n\'existe pas";
    END IF;
END;');

        //Procédure Delete Produit

        $this->addSql('CREATE OR REPLACE PROCEDURE SupprimerProduit (
    IN p_id_produit INT
)
BEGIN
    -- Vérifier si le produit avec l\'ID spécifié existe
    DECLARE produit_count INT;
    SELECT COUNT(*) INTO produit_count FROM produit WHERE id= p_id_produit;

    IF produit_count > 0 THEN
    -- Supprimer le produit de la table
        DELETE FROM produit WHERE id= p_id_produit;
    ELSE
        SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Le produit avec l\'ID spécifié n\'existe pas";
    END IF;
END');

        //Procédure Delete User

        $this->addSql('CREATE OR REPLACE PROCEDURE SupprimerUtilisateur (
    IN p_id_user INT
)
BEGIN
    -- Vérifier si l\'utilisateur avec l\'ID spécifié existe
    DECLARE user_count INT;
    SELECT COUNT(*) INTO user_count FROM user WHERE id= p_id_user;

    IF user_count > 0 THEN
        
        -- Supprimer l\'utilisateur de la table panier
        DELETE FROM panier WHERE user_id= p_id_user;
        

        -- Supprimer les lignes de la table commande de l\'utilisateur
        DELETE FROM commande WHERE user_id = p_id_user;
        
        --Supprimer les lignes de la table message de l\'utilisateur
        DELETE FROM message WHERE user_id = p_id_user;
        
        -- Supprimer l\'utilisateur de la table user
         DELETE FROM user WHERE id= p_id_user;
       
    ELSE
        SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "L\utilisateur avec l\ID spécifié n\existe pas";
    END IF;
END;');

        //Procédure pour ajouter une commande après avoir payé

        $this->addSql('CREATE OR REPLACE PROCEDURE AjouterCommandeEtSupprimerPaniers (
    IN p_id_user INT,
    IN p_code_promo VARCHAR(255)
)
BEGIN
    DECLARE code_promo_exists INT;

    -- Vérifier si le code promo existe
    SELECT COUNT(*) INTO code_promo_exists
    FROM code_promo
    WHERE nom_code = p_code_promo;

    -- Si le code promo existe, décrémenter le nombre d\'utilisations
    IF code_promo_exists > 0 THEN
        UPDATE code_promo
        SET nbr_use = nbr_use - 1
        WHERE nom_code = p_code_promo AND nbr_use > 0;

        -- Supprimer le code promo si nbr_use atteint 0
        IF (SELECT nbr_use FROM code_promo WHERE nom_code = p_code_promo) = 0 THEN
            DELETE FROM code_promo
            WHERE nom_code = p_code_promo;
        END IF;
    END IF;

    -- Ajouter des commandes pour chaque produit dans le panier de l\'utilisateur
    INSERT INTO commande (date, prix, user_id, quantite, nom_produit, id_produit)
    SELECT CURRENT_DATE(), produit.prix * panier.quantite, p_id_user, panier.quantite, produit.nom, panier.produit_id
    FROM panier
    JOIN produit ON panier.produit_id = produit.id
    WHERE panier.user_id = p_id_user;

    -- Décrémenter la quantité de chaque produit dans la table produit
    UPDATE produit
        JOIN panier ON produit.id = panier.produit_id
        SET produit.quantite = produit.quantite - panier.quantite
        WHERE panier.user_id = p_id_user;

    -- Supprimer tous les paniers associés à l\'utilisateur
    DELETE FROM panier WHERE user_id = p_id_user;
END;');

        $this->addSql('CREATE or replace PROCEDURE InsertMessage(IN p_id_user INT, IN p_message VARCHAR(3000))
BEGIN
    DECLARE user_exists INT;
    DECLARE user_name VARCHAR(50);
    DECLARE user_surname VARCHAR(50);
    DECLARE user_mail VARCHAR(180);

    -- Vérifie si l\'utilisateur avec l\'ID donné existe
    SELECT COUNT(*) INTO user_exists FROM user WHERE id = p_id_user;
    
    SELECT name, surname, email INTO user_name, user_surname, user_mail
    FROM user
    WHERE id = p_id_user;

    -- Si l\'utilisateur existe, insérer dans la table message
    IF user_exists > 0 THEN
        INSERT INTO message (nom, prenom, mail, user_id, message) 
        VALUES (user_name, user_surname, user_mail, p_id_user, p_message);
    ELSE
        SIGNAL SQLSTATE "45000"
        SET MESSAGE_TEXT = "L\'utilisateur avec l\'ID spécifié n\'existe pas.";
    END IF;
END;');

        $this->addSql('CREATE or replace PROCEDURE DeleteMessage(IN p_message_id INT)
BEGIN
    DECLARE message_exists INT;

    -- Vérifie si le message avec l\'ID donné existe
    SELECT COUNT(*) INTO message_exists FROM message WHERE id = p_message_id;

    -- Si le message existe, le supprimer
    IF message_exists > 0 THEN
        DELETE FROM message WHERE id = p_message_id;
    ELSE
        SIGNAL SQLSTATE "45000"
        SET MESSAGE_TEXT = "Le message avec l\'ID spécifié n\'existe pas.";
    END IF;
END;');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2A76ED395');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2F347EFB');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE code_promo');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
