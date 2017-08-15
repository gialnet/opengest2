//
// determinar el tipo mime de un fichero
//
function populateContentType(fileFieldId) {
   var extension = getExtension(fileFieldId);
   var contentType = "application/octet-stream";
   if ( extension == "txt" ) {
     contentType= "text/plain";
   } else if ( extension == "htm" || extension == "html" ) {
     contentType= "text/html";
   } else if ( extension == "jpg" || extension == "jpeg" ) {
     contentType = "image/jpeg";
   } else if ( extension == "gif" ) {
     contentType = "image/gif";
   } else if ( extension == "png" ) {
     contentType = "image/png";
   }

   var textfield = document.getElementById("idcontent-type");
   if ( textfield ) {
     textfield.value = contentType;
   }
}
