webpackJsonp([31],{205:function(e,n,i){!function(n,i){e.exports=i()}(0,function(){"use strict";var e,n={name:"hr",messages:{_default:function(e){return"Vrijednost "+e+" ne valja."},after:function(e,n){return e+" mora biti poslje "+n[0]+"."},alpha:function(e){return e+" može sadržavati samo abecedne znakove."},alpha_dash:function(e){return e+" može sadržavati alfanumeričke znakove kao i crtice i podvlake."},alpha_num:function(e){return e+" može sadržavati samo alfanumeričke znakove."},alpha_spaces:function(e){return e+" može sadržavati samo abecedne znakove kao i razmake."},before:function(e,n){return e+" mora biti prije "+n[0]+"."},between:function(e,n){return e+" mora biti između "+n[0]+" i "+n[1]+"."},confirmed:function(e){return"Potvrda "+e+" ne odgovara."},credit_card:function(e){return e+" nije valjan."},date_between:function(e,n){return e+" mora biti između "+n[0]+" i "+n[1]+"."},date_format:function(e,n){return"The "+e+" mora biti u formatu "+n[0]+"."},decimal:function(e,n){void 0===n&&(n=[]);var i=n[0];return void 0===i&&(i="*"),e+" mora biti numerički i može sadržavati"+("*"===i?"":" "+i)+" decimalne bodove."},digits:function(e,n){return e+" mora biti numerički i točno sadrživati "+n[0]+" znamenke."},dimensions:function(e,n){return e+" mora biti "+n[0]+" piksela za "+n[1]+" piksela."},email:function(e){return e+" mora biti važeća e-pošta."},excluded:function(e){return"Vrijednost "+e+" mora biti važeća vrijednost."},ext:function(e){return e+" mora biti važeća datoteka."},image:function(e){return e+" mora biti slika."},included:function(e){return"Vrijednost "+e+" mora biti važeća vrijednost."},ip:function(e){return e+" mora biti važeća IP adresa."},max:function(e,n){return e+" ne smije biti veći od "+n[0]+" znakova."},max_value:function(e,n){return"Vrijednost "+e+" mora biti "+n[0]+" ili manje."},mimes:function(e){return e+" mora imati valjanu vrstu datoteke."},min:function(e,n){return e+" mora biti barem "+n[0]+" znakova."},min_value:function(e,n){return"Vrijednost "+e+" mora biti "+n[0]+" ili više."},numeric:function(e){return e+" može sadrživati samo numeričke znakove"},regex:function(e){return"Oblik "+e+" nije važeći."},required:function(e){return"Polje "+e+" je obavezno."},size:function(e,n){return e+" mora biti manje od "+function(e){var n=1024,i=0==(e=Number(e)*n)?0:Math.floor(Math.log(e)/Math.log(n));return 1*(e/Math.pow(n,i)).toFixed(2)+" "+["Byte","KB","MB","GB","TB","PB","EB","ZB","YB"][i]}(n[0])+"."},url:function(e){return e+" nije važeći URL."}},attributes:{}};return"undefined"!=typeof VeeValidate&&VeeValidate.Validator.localize(((e={})[n.name]=n,e)),n})}});