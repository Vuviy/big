webpackJsonp([21],{215:function(a,n,e){!function(n,e){a.exports=e()}(0,function(){"use strict";var a,n={name:"ms_MY",messages:{_default:function(a){return a+" tidak sah."},after:function(a,n){var e=n[0];return a+" perlulah selepas "+(n[1]?"atau sama dengan ":"")+e+"."},alpha:function(a){return a+" hanya boleh mempunyai karakter abjad sahaja."},alpha_dash:function(a){return a+" boleh mempunyai karakter angka-abjad, sengkang dan garis bawah."},alpha_num:function(a){return a+" hanya boleh mempunyai karakter angka-abjad."},alpha_spaces:function(a){return a+" hanya boleh mempunyai karakter abjad termasuklah aksara ruang."},before:function(a,n){var e=n[0];return a+" perlulah sebelum "+(n[1]?"atau sama dengan ":"")+e+"."},between:function(a,n){return a+" perlulah di antara "+n[0]+" dan "+n[1]+"."},confirmed:function(a){return a+" pengesahan tidak sepadan."},credit_card:function(a){return a+" tidak sah."},date_between:function(a,n){return a+" perlulah di antara "+n[0]+" dan "+n[1]+"."},date_format:function(a,n){return a+" perlulah dalam format "+n[0]+"."},decimal:function(a,n){void 0===n&&(n=[]);var e=n[0];return void 0===e&&(e="*"),a+" perlulah dalam bentuk angka dan boleh mempunyai "+(e&&"*"!==e?e:"")+" titik perpuluhan."},digits:function(a,n){return a+" perlulah dalam bentuk angka dan mempunyai "+n[0]+" digit."},dimensions:function(a,n){return a+" perlulah berdimensi "+n[0]+" pixel darab "+n[1]+" pixels."},email:function(a){return a+" perlulah dalam format emel yang sah."},excluded:function(a){return a+" perlulah sah."},ext:function(a){return a+" perlulah dalam format fail yang sah."},image:function(a){return a+" perlulah dalam bentuk imej."},included:function(a){return a+" perlulah dalam nilai yang sah."},integer:function(a){return a+" perlulah dalam bentuk integer."},ip:function(a){return a+" perlulah dalam format alamat ip yang sah."},length:function(a,n){var e=n[0],r=n[1];return r?"Panjang "+a+" perlulah bernilai di antara "+e+" dan "+r+".":"Panjang "+a+" perlulah bernilai "+e+"."},max:function(a,n){return a+" perlulah tidak melebihi "+n[0]+" karakter."},max_value:function(a,n){return a+" perlulah bernilai "+n[0]+" atau kurang."},mimes:function(a){return a+" perlulah mempunyai jenis fail yang sah."},min:function(a,n){return a+" perlulah sekurang-kurangnya mempunyai "+n[0]+" karakter."},min_value:function(a,n){return a+" perlulah bernilai "+n[0]+" atau lebih."},numeric:function(a){return a+" perlulah mempunyai hanya karakter angka sahaja."},regex:function(a){return"Format "+a+" tidak sah."},required:function(a){return a+" adalah wajib."},size:function(a,n){return"Saiz "+a+" perlulah kurang daripada "+function(a){var n=1024,e=0==(a=Number(a)*n)?0:Math.floor(Math.log(a)/Math.log(n));return 1*(a/Math.pow(n,e)).toFixed(2)+" "+["Byte","KB","MB","GB","TB","PB","EB","ZB","YB"][e]}(n[0])+"."},url:function(a){return a+" bukan URL yang sah."}},attributes:{}};return"undefined"!=typeof VeeValidate&&VeeValidate.Validator.localize(((a={})[n.name]=n,a)),n})}});