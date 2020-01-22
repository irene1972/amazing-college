import $ from 'jquery';

class MyNotes{

  constructor(){

    this.editButton = $(".edit-note");
    this.deleteButton = $(".delete-note");
    this.events();
  }

  events(){
    this.editButton.on( "click", this.editNote.bind(this) );
    this.deleteButton.on( "click", this.deleteNote.bind(this) );
  }

  editNote(){
    alert('Editamos!!');
  }

  deleteNote(){
    alert('Eliminamos!!');
    $.ajax({
      //http://localhost:3000/amazing-college/app/wp-json/wp/v2/note
      //http://localhost:3000/amazing-college/app/wp-json/wp/v2/note/95
      beforeSend: (xhr) => {
        xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/95',
      type: 'DELETE',
      success: ( response ) => {
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