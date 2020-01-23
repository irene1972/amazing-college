import $ from 'jquery';

class MyNotes{

  constructor(){
    this.editButton = $(".edit-note");
    this.deleteButton = $(".delete-note");
    this.buttonSave = $(".update-note");
    this.events();
  }

  events(){
    this.editButton.on( "click", this.editNote.bind(this) );
    this.deleteButton.on( "click", this.deleteNote );
    this.buttonSave.on( "click", this.updateNote.bind(this) );
  }

  editNote( event ){
    var elemLiNote = $(event.target).parents("li");

    if( elemLiNote.data("state") == "editable" ){
      this.makeNoteReadOnly( elemLiNote );
    }else{
      this.makeNoteEditable( elemLiNote );
    }

  }

  makeNoteEditable( elemLiNote ){
    elemLiNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i>Cancel');
    elemLiNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
    elemLiNote.find(".update-note").addClass("update-note--visible");
    elemLiNote.data("state", "editable");
  }

  makeNoteReadOnly( elemLiNote ){
    elemLiNote.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i>Edit');
    elemLiNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
    elemLiNote.find(".update-note").removeClass("update-note--visible");
    elemLiNote.data("state", "cancel");
  }

  deleteNote( event ){
    var elemLiNote = $(event.target).parents("li");
    var id_note = elemLiNote.data('id');

    $.ajax({
      //http://localhost:3000/amazing-college/app/wp-json/wp/v2/note
      //http://localhost:3000/amazing-college/app/wp-json/wp/v2/note/95
      beforeSend: (xhr) => {
        xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/' + id_note,
      type: 'DELETE',
      success: ( response ) => {
        elemLiNote.slideUp();
        console.log('The note has been removed');
        console.log( response );
      },
      error: ( response ) => {
        console.log('Sorry, there was an error');
        console.log( response );
      }
    });
  }
  
  updateNote( event ){
    var elemLiNote = $(event.target).parents("li");
    var id_note = elemLiNote.data('id');
    var title = elemLiNote.find(".note-title-field").val();
    var content = elemLiNote.find(".note-body-field").val();

    // WP espera que le pasemos los datos con estas propiedades concretas: title, content...
    var ourUpdatedPost = {
      'title': title,
      'content': content
    }

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/' + id_note,
      type: 'POST',
      data: ourUpdatedPost,
      success: ( response ) => {
        this.makeNoteReadOnly( elemLiNote );
        console.log('The note has been updated');
        console.log( response );
      },
      error: ( response ) => {
        console.log('Sorry, there was an error');
        console.log( response );
      }
    });
  }

}

export default MyNotes;