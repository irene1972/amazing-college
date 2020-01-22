import $ from 'jquery';

class MyNotes{

  constructor(){
    this.editButton = $(".edit-note");
    this.deleteButton = $(".delete-note");
    this.events();
  }

  events(){
    this.editButton.on( "click", this.editNote );
    this.deleteButton.on( "click", this.deleteNote );
  }

  editNote( event ){
    var elemLiNote = $(event.target).parents("li");
    //var id = elemLiNote.data('id');

    elemLiNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
    elemLiNote.find(".update-note").addClass("update-note--visible");
  }

  deleteNote( event ){
    var elemLiNote = $(event.target).parents("li");
    var id = elemLiNote.data('id');

    $.ajax({
      //http://localhost:3000/amazing-college/app/wp-json/wp/v2/note
      //http://localhost:3000/amazing-college/app/wp-json/wp/v2/note/95
      beforeSend: (xhr) => {
        xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/' + id,
      type: 'DELETE',
      success: ( response ) => {
        elemLiNote.slideUp();
        console.log('Congratulations');
        console.log( response );
      },
      error: ( response ) => {
        console.log('Sorry');
        console.log( response );
      }
    });
  }
  
}

export default MyNotes;