r(function(){
	"use strict";
   var dialog = document.querySelector("dialog#unless-dialog");
   if (dialog) {
      if (!dialog.showModal) {
         dialogPolyfill.registerDialog(dialog);
      }
      dialog.showModal();
      dialog.querySelector(".close").addEventListener("click", function() {
         dialog.close();
      });
   }
   var snackbarContainer = document.querySelector("div#unless-toast");
   if (snackbarContainer) {
      var data = {
         message: "Your settings were updated successfully"
      };
      snackbarContainer.MaterialSnackbar.showSnackbar(data);
   };
});
function r(f){/in/.test(document.readyState)?setTimeout('r('+f+')',9):f()}