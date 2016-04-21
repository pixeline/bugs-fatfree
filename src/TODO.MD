# todo

## must-have

- ATTACHMENT/ADD : utiliser verot.net au lieu de la classe existante >> http://fatfreeframework.com/web#receive  + VEROT.NET + https://github.com/blueimp/jQuery-File-Upload/wiki/Setup#using-jquery-file-upload-ui-version-with-a-custom-server-side-upload-handler
- ATTACHMENT/DELETE

- ISSUE/CHANGESTATUS ( close / wontfix )
- ISSUE/REASSIGN
- ISSUE/DELETE
- COMMENT/ADD
- COMMENT/READ
- COMMENT/EDIT
- COMMENT/DELETE

## nice-to-have
- add FONTAWESOME in SASS _ http://purecss.io/buttons/#yui_3_17_2_1_1460767341528_15
- page title tag: "issue title / project title / Bugs"
- améliorer l'uploader (permettre le multifile / Paste URL ou File Selector / File preview before upload, drag to window... )
- permettre le markdown / Markdown wysiwyg
- le chiffre à coté du projet n'est pas pertinent (devrait afficher les bugs assignés à l'utilisateur)
- commenter un ticket
- changer le statut d'un ticket (ouvrir / fermer)
- ré-assigner un ticket
- autolinker les liens
- installation wizard

## Done
- ISSUE/ADD
- translation system (create {iso}.php inside app/lang/)

# APPLICATION ARCHITECTURE
- Au centre de la gestion de l' UI, la SESSION
SESSION.user
SESSION.project
SESSION.issue

qui doit toujours refléter l'état en cours de l'application.