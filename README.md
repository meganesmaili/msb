
**MStitch Boutique**

Site e-commerce de vente de produits artisanaux.

**Bien se placer à la racine du projet.**

- Pour initaliser le projet, entrez :

> `composer update`

> `composer install`

> `npm install` 

> `npm run build`

> `symfony console doctrine:database:create`

> `symfony console make:migration`

> `symfony console doctrine:migrations:migrate`

> `symfony console doctrine:schema:update --force`

> `composer require orm-fixtures --dev`

> `composer require knplabs/knp-paginator-bundle`

> `composer require symfonycasts/reset-password-bundle`

> `composer require vich/uploader-bundle`

> `composer require liip/imagine-bundle`

> `composer require easycorp/easyadmin-bundle`

> `symfony console doctrine:schema:update --force`

> `symfony console doctrine:fixtures:load`

## from **features/BDD**

### Création d'une BDD MStich Boutique 

- Commande dans VSCode

> `symfony console doctrine:database:create`

- Creation des Entity

> `symfony console make:entity Products`

> `symfony console make:entity Category`

> `symfony console make:entity Matter`

> `symfony console make:entity Opinion`

> `symfony console make:entity User`

- Relier avec php

> `symfony console make:migration`

> `symfony console doctrine:migrations:migrate`

> `symfony console doctrine:schema:update --force`

- Installer le bundle Fixtures

> `composer require orm-fixtures --dev`

**Supprimer le fichier AppFixtures !!**

- Création des Fichiers Fixtures pour les Entity

> `symfony console make:fixtures DataFixtures`

> `symfony console doctrine:fixtures:load`

### Jointures des Entity

## from **features/BDD**


- Route HomeController :

> `PS C:\laragon\www\MStitchBoutique> symfony console make:controller HomeController`

- Route ProductController :

> `PS C:\laragon\www\MStitchBoutique> symfony console make:controller ProductController`

- Route CategoryController :

> `PS C:\laragon\www\MStitchBoutique> symfony console make:controller CategoryController`

- Route MatterController :

> `PS C:\laragon\www\MStitchBoutique> symfony console make:controller MatterController`

- Route CartController :

> `PS C:\laragon\www\MStitchBoutique> symfony console make:controller CartController`

- Route AdminController :

> `PS C:\laragon\www\MStitchBoutique> symfony console make:controller AdminController`

- Route OpinionController :

> `PS C:\laragon\www\MStitchBoutique> symfony console make:controller OpinionController`

#### L'entité User a été crée lors de la création de la table User avec :

- id	
- email 
- firstname
- lastname
- pseudo
- roles 
- password 	varchar(255)

### Authentification :

La table User crée et le le fichier de configuration sécurité.yaml est à jour mettons en place nos connexion et deconnexion.

- ligne de commande dans le terminal :
 
> `symfony console make:auth`

> `PS C:\laragon\www\Mstitchboutique> symfony console make:auth  `
 
- Répondre aux questions :

> `What style of authentication do you want? [Empty authenticator] :`

Répondre 1 afin afin de créer notre formulaire d'identification automatiquement.
 
> `The class name of the authenticator to create (e.g. AppCustomAuthenticator) :`

Choix d'un nom au fichier qui se chargera de l'authentification : ça sera "UserAuthenticator".
 
> `Choose a name for the controller class (e.g. SecurityController) [SecurityController] :`

Choisir un nom pour le contrôleur qui contient les routes vers le formulaire de connexion et vers la déconnexion. Je choisi par défaut : "SecurityController".
  
> `Do you want to generate a '/logout' URL? (yes/no) [yes] :`

Nous répondons "yes" afin de donner la possibilité à l'utilisateur de se déconnecter.

- Création de 3 fichiers :

    - **src/Security/UserAuthenticator.php**
    - **src/Controller/SecurityController.php**
    - **templates/security/login.html.twig**

- Modifications à apporter :

Ouvrir le fichier **"src/Security/UserAuthenticator.php".**

```php
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        // For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }
```

- Changer la route et mettre 'app-home' au lieu de 'some_route' afin de définir le chemin vers 'app-home' une fois l'utilisateur authentifié"

```php
public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // For example:
        // return new RedirectResponse($this->urlGenerator->generate('some_route'));
        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }
```
---
### Inscription :
     
- Dans le terminal, mettre :
     
> `symfony console make:registration-form`
     
- Répondre aux questions :
     
> `Do you want to add a @UniqueEntity validation annotation on your Users class to make sure duplicate accounts aren't created? (yes/no) [yes] :`

Répondre yes afin d'avoir plusieurs comptes utilisateurs avec le même mail.
     
> `Do you want to send an email to verify the user's email address after registration? (yes/no) [yes] :`

Voulez-vous  veut envoyer un e-mail à l'utilisateur afin de vérifier la validité de son adresse e-mail. Il est préférable de répondre Yes
     
> `What email address will be used to send registration confirmations? e.g. mailer@your-domain.com :`

Si vous avez répondu oui à la question précédente, entrez une adresse e-mail. Elle sera utilisée en tant qu'adresse expéditeur.
     
> `What "name" should be associated with that email address? e.g. "Acme Mail Bot" :`

Entrez  un nom qui sera utilisé lors de l'envoi de l'e-mail de vérification. pour moi cel sera 'MStitchBoutique'
      
> `Do you want to automatically authenticate the user after registration? (yes/no) [yes] :`

Si vous voulez connecter automatiquement l'utilisateur une fois qu'il est inscrit répondre oui.


- Vu que nous avons répondu oui à la question précendente il faut installer :
      
> `composer require symfonycasts/verify-email-bundle`
      
- Ouvrir le fichier "**src/Controller/RegistrationController.php**" et modifiez la méthode **verifyUserEmail()**

```php
public function verifyUserEmail(Request $request, TranslatorInterface $translator, CategoryRepository $categoryRepository, MatterRepository $matterRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register', [
                'productsCategory' => $categoryRepository->findAll(),
                'productsMatter' => $matterRepository->findAll()
            ]
        
        );
            
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_home');
    }
```

- Modifiez la dernière ligne de la méthode, à savoir $this->redirectToRoute() , j'ai mis 'app_home' afin de rediriger sur la page d'acceuil une fois son       email vérifié.
    
- Mise à jour de la base de donnée :
    
> `symfony console doctrine:schema:update --force`
    
---

### Mot de passe oublié ?
    
- Sur le terminal tapé les lignes de commandes :
    
> `composer require symfonycasts/reset-password-bundle`
    
> `symfony console make:reset-password`
    
- Répondre aux questions :
    
> `What route should users be redirected to after their password has been successfully reset? [app_home] :`

Des que l'utilisateur a correctement modifié son mot de passe, où le rediriger ? Le mieux reste le formulaire de connexion soit "app_login".

> `What email address will be used to send reset confirmations? e.g. mailer@your-domain.com :`

Ici, nous pouvons choisir l'adresse e-mail utilisée pour envoyer l'e-mail permettant de modifier le mot de passe.

> `What "name" should be associated with that email address? e.g. "Acme Mail Bot" :`

On définit le nom qui sera affiché dans le mail de modification du mot de passe envoyé.
       
- Mettre à jour la base de données :
       
> `symfony console doctrine:schema:update --force`

---
- Pour ajouter un "**remember me**" lors de la connexion, aller sur : 
       
- Dans le fichier **config/packages/security.yaml** sous le main écrire :

```yaml
        main:
            remember_me:
                secret: '%kernel.secret%'
                lifetime: 2419200 #1 month in seconds
```
---
### Mise en place de Mailhog :
      
- télécharger votre version à l'adresse https://github.com/mailhog/MailHog/releases et lancer l'executable.
      
- Aller dans le fichier **.env** et mettre ceci ligne 42 : 

> `MAILER_DSN=smtp://localhost:1025`
      
-Pour mettre en place l’envoie automatique des mails, aller dans **.env** et modifier ligne 22 :

> `MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=1`

- Pour envoyer les mails automatiquement, aller dans **config\packages\messenger.yaml** et décommenter la ligne 16 ainsi que modifier la ligne 19 :

```yaml
sync: 'sync://'

Symfony\Component\Mailer\Messenger\SendEmailMessage: sync

- Dans **templates/security/login.html.twig** décommenter :

```html  
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="_remember_me"> Remember me
            </label>
        </div>
```
---
### Installer VichUploaderBundle, qui est un otuil/bundle de gestion des images :
        
- Se placer dans le dossier racine du projet, taper dans le terminal :

> `composer require vich/uploader-bundle`
        
- Pour activer l’outil, aller dans config/packages/vich_uploder.yaml et décommenter à partir de la ligne 4, le modifier en fonction de ses besoins,           puis rajouter une autre option : 

```yaml
        mappings:
            products:
                uri_prefix: /images/products
                upload_destination: '%kernel.project_dir%/public/images/products'
                namer: Vich\UploaderBundle\Naming\SmartUniqueNamer

          Rajouter aussi ceci sous la ligne 2 :

        metadata:
            type: attribute
```
### Mise en place des avis

Création d'un fichier js qui se nomme stars.js

- Enregistrement dans l'input du score attribué par un user.
- Mise en place d'écouteurs d'évènement au "click" et au "mousseout".
- Création d'un ecouteur d'evenement pour recuperer la valeur de la note donnée.
- Garder la valeur du click sur l'étoile.


### Mise en place de la route dans le controller et d'une vue pour la section des dépots des avis

- Création d'un formulaire et insertion dans la base de données.
- Choix d'un produit
- Dépôt d'un commentaire
- Note attribué à un produit

- Installation Easy Admin:

Dans le terminal lancer la commande:

> `composer require easycorp/easyadmin-bundle`

Création du DashBoard:

> `symfony console make:admin:dashboard`

"La page d'aministration du site est désormé accessible sous mstitchboutique.test/admin"

Création des fichiers CRUD:

Dans le terminal lancer la commande:

> `symfony console make:admin:crud`

Répondre aux questions:

 Which Doctrine entity are you going to manage with this CRUD controller?:
  [0] App\Entity\Product
  [1] App\Entity\Category
  [2] App\Entity\ResetPasswordRequest
  [3] App\Entity\Matter
  [4] App\Entity\User
  [5] Vich\UploaderBundle\Entity\File
 > 
 Choisir quel Doctrine on veut manager, pour nous cela sera Product, Matter, User, Category.

 Le faire pour chaque doctrine.
 Taper entrer à chaque question
  > `Which directory do you want to generate the CRUD controller in? [src/Controller/Admin/]:`
  > ` Namespace of the generated CRUD controller [App\Controller\Admin]:`

Créer la route:

    #[Route('/admin', name: 'admin')]

        public function index(): Response
        {
                    
            return $this->render('admin/index.html.twig');
        }

Modifier le fichier DashboardController.php afin que le Dashboard porte le nom MStitchBoutique:

     public function configureDashboard(): Dashboard
        {
           return Dashboard::new()->setTitle('MStitchBoutique');
                
        }

Modifier les menuItem qui vont apparaître pour l'administrateur dans le DashboardController.php

    public function configureMenuItems(): iterable
    {
            
        return [

            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'), // Ajout de Dashboard            
            MenuItem::linkToCrud('utilisateurs', 'fas fa-list', User::class),            
            MenuItem::linkToCrud('Products', 'fas fa-list', Products::class),                         
            MenuItem::linkToCrud('Category', 'fas fa-list', Category::class),
            MenuItem::linkToCrud('Matter', 'fas fa-list', Matter::class),
            
        ];
            
    }

Dans les fichiers CrudController.php modifier la public Function:

ProductsCrudController.php

    public function configureFields(string $pageName): iterable
    {
        
        return [
            TextField::new('name', 'nom'),
            AssociationField::new('matter', 'matière'),
            AssociationField::new('category', 'catégorie'),
            TextEditorField::new('description'),
            NumberField::new('quantity', 'En stock'),
            TextField::new('profileFile', 'image') //Pour charger l'image dans l'edit
            ->setFormType(VichImageType::class)// redimenssionnement avec VichImage
            ->onlyOnForms(), 
            ImageField::new('picture', 'image') // faire apparaître l'image dans le formulaire
            ->setBasePath('images/products') // chemin d'accés de l'image dans le formulaire
            ->setUploadDir('public/images/products')
            ->hideOnForm() //pour n'apparaite que dans le form
            
        ];
    }
    
    Ajouter les Information de la table phpMyadmin que l'on veut récupérer.

UtilisateursCrudController.php

    public function configureFields(string $pageName): iterable
        {
            yield TextField::new('email');
            yield ArrayField::new('roles');
            yield TextField::new('firstname');
            yield TextField::new('lastname');
            yield TextField::new('pseudo');
            yield TextField::new('password')->setFormType(PasswordType::class)->onlyOnForms()->onlyWhenCreating();
            
            
            
        }

MatterCrudController.php

public function configureFields(string $pageName): iterable
    {
        return [
            return Matter::class;
        ];
    }

CategoryCrudController.php

public function configureFields(string $pageName): iterable
    {
        return [
            return Category::class;
        ];
    }


- **Police décriture**

Couleurs :

:root {
    --darkOrchid: #2d3436; 
    --white: #FFFFFF;
    --gray: #40434a;
    --medium-gray: #636e72;
    --medium-light-gray: #706f6f;
    --light-gray: #e3e3e3;
    --line-and-btn-gray: #c6c6c6;
    --footer-gray: #3c3c3b;
    --mustard: #f7de79;
}
```
