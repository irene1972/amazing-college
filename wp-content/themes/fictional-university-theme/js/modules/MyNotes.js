import $ from 'jquery';

class MyNotes{

  constructor(){
    // Ver nota (*)
    //this.editButton = $(".edit-note");
    //this.deleteButton = $(".delete-note");
    //this.buttonSave = $(".update-note");
    this.elemUL = $("#my-notes");
    this.buttonCreate = $(".submit-note")
    this.events();
  }

  events(){
    this.elemUL.on( "click", ".edit-note", this.editNote.bind(this) );
    this.elemUL.on( "click", ".delete-note", this.deleteNote );
    this.elemUL.on( "click", ".update-note", this.updateNote.bind(this) );
    this.buttonCreate.on( "click" , this.createNote );

    // (*) Hemos modificado toda esta parte para que al crear un elemento nuevo y mostrarlo dinámicamente tras la creación. En el nuevo elemento funcionen los eventos igual que en los anteriores ... 
    //      ... resumiendo el cambio: ahora el onClick está sobre el elemento UL que contendrá siempre los elementos pasados y creados nuevamente (sin posterior recarga de página), sin embargo...
    //      ... el evento sigue correspondiendo al elemento (span edit o span delete) de la misma manera que ya habíamos configurado
    // this.editButton.on( "click", this.editNote.bind(this) );
    // this.deleteButton.on( "click", this.deleteNote );
    // this.buttonSave.on( "click", this.updateNote.bind(this) );
    // this.buttonCreate.on( "click" , this.createNote );
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

        if( response.userNoteCount < 4 )
          $(".note-limit-message").removeClass('active');

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

  createNote(){
    //var elemDivNewNote = $(event.target).parents("div");
    var inputTitle = $(".new-note-title");
    var textareaContent = $(".new-note-body");

    var ourNewPost = {
      'title': inputTitle.val(),
      'content': textareaContent.val(),
      'status': 'publish'   // by dafault is 'draft' the status. IMPORTANTE! Lo dejamos en publish (aunque debería ser private) pq vamos a proteger este punto desde php
    }

    // Si no incluimos el STATUS -> PUBLISHED crearíamos un borrador.
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/',
      type: 'POST',
      data: ourNewPost,
      success: ( response ) => {
        //$(".new-note-title, .new-note-body").val('');
        inputTitle.val('');
        textareaContent.val('');
        $(`
        <li data-id="${response.id}">
          <input value="${response.title.raw}" class="note-title-field" readonly />
          <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
          <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
          <textarea class="note-body-field" readonly >${response.content.raw}</textarea>
          <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Update</span>
        </li>
        `).prependTo("#my-notes").hide().slideDown();   // Con la finalidad de que no aparezca de golpe el elemento, primero lo escondemos ('hide') y luego hacemos el 'slideDown'
        console.log('The note has been created');
        console.log( response );
      },
      error: ( response ) => {

        if( response.responseText == 'You have reached your note limit.' )
          $(".note-limit-message").addClass("active");

        console.log('Sorry, there was an error');
        console.log( response );

      }
    });

  }

}

export default MyNotes;