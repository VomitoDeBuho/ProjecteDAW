# Projecte d'Administració de Certificacions MOS

## Descripció

Aquest projecte consisteix en una aplicació web per a l'administració de certificacions MOS (Microsoft Office Specialist). L'aplicació permet als administradors gestionar les dades dels usuaris que s'han registrat per realitzar exàmens de certificació MOS. Utilitza l'API de Google per autenticar els usuaris a través de Google Sign-In i proporciona una interfície senzilla per administrar i consultar informació dels usuaris.
Permet enviar notificacions als usuaris com als administradors, utilitzant la llibreria PHPMailer.
Permet als usuaris enviar una petició d'examen donat un formulari d'alta, ubicat tot, dintre de la carpeta "usuari"

## Característiques principals

1. **Introducció del formulari per part de l'usuari:**
   - L'usuari disposa d'un formulari per poder entrar les dades sol·licitades (Nom, cognom, correu, curs, justificant, certificacions...).
   - El formulari està molt orientat a seguretat, intentant el màxim posible evitar atacs amb un captcha i validació extensa del backend i frontend de les dades.

2. **Autenticació d'Usuari amb Google Sign-In:**
   - El administrador pot iniciar sessió utilitzant el seu compte de Google a través de Google Sign-In. Si no és l'administrador, l'aplicatiu el farà fora. Tot sota el domini "sapalomera.cat"
   - L'autenticació es realitza utilitzant l'API de Google i OAuth 2.0.

3. **Visualització d'Usuaris Registrats:**
   - Els administradors poden veure la llista d'usuaris registrats per als exàmens de certificació MOS.
   - La llista mostra informació com el nom, cognoms, correu electrònic, curs, certificacions, data de sol·licitud...
   - L'administrador és l'encarregat de validar si les dades introduides son bones, en cas de que fosin correctes, donar credencials i data d'exàmen através de l'aplicatiu.

4. **Actualització de Dades d'Usuaris:**
   - Els administradors poden editar la informació dels usuaris, com ara comentaris, dates d'exàmens i credencials.
   - Les actualitzacions es reflecteixen a la base de dades i s'emmagatzemen per a la seva posterior consulta.
   - És pot eliminar una petició erronea.

5. **Descàrrega de Justificants:**
   - Els usuaris poden adjuntar justificants d'inscripció en format d'arxiu PDF.
   - Els administradors poden descarregar els justificants per a la seva revisió i gestió.

6. **Enviament de Credencials d'Accés:**
   - Els administradors poden enviar credencials d'accés als usuaris per als exàmens.
   - S'envien les dades d'accés, com ara usuari, contrasenya i codi Practice Test, per correu electronic.

7. **Cerca i Filtrat d'Usuaris:**
   - Els usuaris poden realitzar cerques i filtrar la llista d'usuaris segons diferents criteris.
   - Facilita la navegació i la gestió de la informació amb una taula i paginació.

## Requisits del Projecte

 - Petició d’examen indicant nom, grup, examen adjuntant el justificant de pagament. Aquest petició hauria d’arribar per correu a certificacions@sapalomera.cat. ✅
 - Quan es doni l’ok, un cop comprovat el pagament, se li ha d’enviar un correu a l’alumne amb usuari, pwd, un codi d’examen pretest, les instruccions per accedir-hi per correu electrònic i se li ha de demanar que triï data dins l’horari previst. ✅
 - L’administrador ha de poder entrar les dates previstes. ✅
 - Espai de consulta dels exàmens previstos a cada hora per l’administrador. ✅

## Millores a desenvolupar del Projecte

- 8 alumnes màxim per hora.
- Guardar les dades de cada examen que es realitza, l’alumne que el realitza i si aprova o no. (Es pot fer a través del espai de comentaris ✅)
- Estadístiques de quantitat d’exàmens realitzats de cada, quantitat d’exàmens aprovats de cada, quantitat d’alumnes que treuen el títol “Associate” i quantitat de diners recollits.
- Poder carregar el user, password i codi Practice Test en un csv.
- Que el calendari enviï recordatoris a alumnes i administrador. (Això s'hauria de fer amb un cron, però pot ser, és més feina de Sistemes)



## Ús
1. Formulari: L'usuari utilitza el formulari d'inscripció, fent un registre a la BBDD, l'usuari rep un correu amb la confirmació i l'administrador un avis amb un resum de les dades introduides.
2. Iniciar sessió: L'administrador pot iniciar sessió utilitzant Google Sign-In.
3. Visualitzar Usuaris: Els usuaris registrats es mostren en una taula a la pàgina principal.
4. Descàrrega de Justificants: Es pot "Descarregar" per obtenir el justificant adjunt.
5. Enviament de Credencials: Els administradors poden enviar credencials d'accés als usuaris.
6. Cerca i Filtrat: Cercador dinàmic per cercar usuaris específics i qualsevol camp.
7. L'administrador pot eliminar i editar alguns camps dels usuaris.

## Crèdits

Aquest projecte va ser desenvolupat per Àlex Blàzquez Ruiz com a part del Projecte de DAW.

## Llicència

Aquest projecte està sota la Llicència de Reconocimiento-NoComercial-CompartirIgual --> https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode
