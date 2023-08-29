# Projecte d'Administració de Certificacions MOS

## Descripció

Aquest projecte consisteix en una aplicació web per a l'administració de certificacions MOS (Microsoft Office Specialist). L'aplicació permet als administradors gestionar les dades dels usuaris que s'han registrat per realitzar exàmens de certificació MOS. Utilitza l'API de Google per autenticar els usuaris a través de Google Sign-In i proporciona una interfície senzilla per administrar i consultar informació dels usuaris.
Permet enviar notificacions als usuaris com als administradors, utilitzant la llibreria PHPMailer.
Permet als usuaris enviar una petició d'examen donat un formulari d'alta, ubicat tot, dintre de la carpeta "usuari"

## Característiques principals

1. **Autenticació d'Usuari amb Google Sign-In:**
   - El administrador pot iniciar sessió utilitzant el seu compte de Google a través de Google Sign-In. Si no és l'administrador, l'aplicatiu el farà fora. Tot sota el domini "sapalomera.cat"
   - L'autenticació es realitza utilitzant l'API de Google i OAuth 2.0.

2. **Visualització d'Usuaris Registrats:**
   - Els administradors poden veure la llista d'usuaris registrats per als exàmens de certificació MOS.
   - La llista mostra informació com el nom, cognoms, correu electrònic, curs, certificacions, data de sol·licitud...
   - L'administrador és l'encarregat de validar si les dades introduides son bones, en cas de que fosin correctes, donar credencials i data d'exàmen através de l'aplicatiu.

3. **Edició i Actualització de Dades d'Usuaris:**
   - Els administradors poden editar la informació dels usuaris, com ara comentaris, dates d'exàmens i credencials.
   - Les actualitzacions es reflecteixen a la base de dades i s'emmagatzemen per a la seva posterior consulta.

4. **Descàrrega de Justificants:**
   - Els usuaris poden adjuntar justificants d'inscripció en format d'arxiu PDF.
   - Els administradors poden descarregar els justificants per a la seva revisió i gestió.

5. **Enviament de Credencials d'Accés:**
   - Els administradors poden enviar credencials d'accés als usuaris per als exàmens.
   - S'envien les dades d'accés, com ara usuari, contrasenya i codi Practice Test.

6. **Cerca i Filtrat d'Usuaris:**
   - Els usuaris poden realitzar cerques i filtrar la llista d'usuaris segons diferents criteris.
   - Facilita la navegació i la gestió de la informació amb una taula i paginació.

## Requisits del Projecte

 - Espai on penjar la informació sobre les certificacions
 - Petició d’examen indicant nom, grup, examen adjuntant el justificant de pagament. Aquest petició hauria d’arribar per correu a certificacions@sapalomera.cat.
 - Quan es doni l’ok, un cop comprovat el pagament, se li ha d’enviar un correu a l’alumne amb usuari, pwd, un codi d’examen pretest, les instruccions per accedir-hi per correu electrònic i se li ha de demanar que triï data dins l’horari previst (canvi de data?).
 - L’administrador ha de poder entrar les dates previstes (8 alumnes màxim per hora).
 - Espai de consulta dels exàmens previstos a cada hora per l’administrador
 - Guardar les dades de cada examen que es realitza, l’alumne que el realitza i si aprova o no (a partit de la confirmació de pagament o en iniciar el procés??) → pàgina per introduir la informació per part de l’administrador.
 - Estadístiques de quantitat d’exàmens realitzats de cada, quantitat d’exàmens aprovats de cada, quantitat d’alumnes que treuen el títol “Associate” i quantitat de diners recollits.


## Ús

1. Iniciar sessió: Els administradors poden iniciar sessió utilitzant Google Sign-In.
2. Visualitzar Usuaris: Els usuaris registrats es mostren en una taula a la pàgina principal.
3. Editar Usuaris: Feu clic a "Editar" per modificar la informació d'un usuari.
4. Descàrrega de Justificants: Feu clic a "Descarregar" per obtenir el justificant adjunt.
5. Enviament de Credencials: Els administradors poden enviar credencials d'accés als usuaris.
6. Cerca i Filtrat: Utilitzeu el camp de cerca per cercar usuaris específics.

## Crèdits

Aquest projecte va ser desenvolupat per [El Teu Nom] com a part de [Nom del Curs o Projecte].

## Llicència

Aquest projecte està sota la Llicència [Tipus de Llicència]. Consulteu l'arxiu [LICENSE](LICENSE) per obtenir més detalls.
