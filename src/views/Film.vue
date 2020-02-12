<template>
  <v-container class="my-5">
    <v-row>
      <template>
        <v-col md="auto">
          <v-img :src="getFilmImgUrl(film_data.url_pic)" height="389px" width="389px" style="border-radius: 1%"></v-img>
        </v-col>
        <v-col>
          <v-list>
            <v-subheader>FILM DATA</v-subheader>
            <v-list-item>
              <v-list-item-content three-line>
                <v-list-item-title>Title</v-list-item-title>
                <v-list-item-subtitle>{{ film_data.title }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-list-item three-line>
              <v-list-item-content>
                <v-list-item-title>Premiere</v-list-item-title>
                <v-list-item-subtitle>{{ film_data.date }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-list-item three-line>
              <v-list-item-content>
                <v-list-item-title>Summary</v-list-item-title>
                <v-list-item-subtitle>{{ film_data.desc }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-list-item three-line>
              <v-list-item-content>
                <v-list-item-title>Genre</v-list-item-title>
                <v-list-item-subtitle>{{ film_data.genre_name }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-col>
      </template>
    </v-row>

    <v-row align="center" class="mx-0" style="background-color:#1E1E1E;margin-top: 20px">
        <div style="margin-left:15px; color: rgba(255, 255, 255, 0.7); font-size: 0.875rem;">RATE THIS FILM</div>
        <v-spacer></v-spacer>
        <v-rating   
          style="margin-left:-20px"
          color="purple"
          background-color="purple lighten-1"
          half-increments
          size="50"
          hover
          v-model="new_film_rating"
          @input="voteFilm()"
        ></v-rating>
        <v-spacer></v-spacer>
    </v-row>

    <v-row style="margin-top: 20px">
      <v-col>
        <v-list>
          <v-subheader>COMMENTS</v-subheader>
          <v-list-item v-for="comment in film_comments" :key="comment.comment_id">
            <v-list-item-avatar>
              <v-img :src="getProfileImgUrl(comment.pic)"></v-img>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>{{ comment.name }}</v-list-item-title>
              <v-list-item-subtitle>{{ comment.comment }}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-col>
    </v-row>

    <v-textarea 
      style="margin-top: 20px"
      outlined
      hint="What do you think about this film? Let everybody know in the comments!"
      name="input-7-4"
      label="Write a comment"
      value=" "
      counter
      :rules="rules"
      v-model="new_comment"
    ></v-textarea>
    
    <v-btn block @click="publishComment()">PUBLISH COMMENT</v-btn>

    <v-snackbar
      v-model="snackbar_show"
      color="success"
      top
    >
    <v-icon>mdi-check</v-icon> 
      Film voted succesfully with a score of {{ this.new_film_rating }}
    </v-snackbar>

    <v-snackbar
      v-model="snackbar_show_error"
      color="error"
      top
    >
    <v-icon>mdi-alert-circle</v-icon> 
      Error: you must be logged to perform that action
    </v-snackbar>

  </v-container>
</template>
<script>

export default {
  name: 'Film',
  data: () => ({
    snackbar_show: false,
    snackbar_show_error: false,
    // Film data
    new_film_rating: 0,
    film_id: null,
    film_data: [],
    film_comments: [],
    new_comment: null,
    // Comment length limitation
    rules: [v => v.length <= 400 || 'Max 400 characters'],
  }),
  // Function called when the virtual DOM has been mounted
  async created() {
    this.film_id = this.$route.query.id;
    let res = await fetch("http://localhost/api/film.php?id=" + this.film_id, {
      credentials: 'include'
    });
    res = await res.json();
    this.film_data = res.movie;
    this.film_comments = res.comments;
  },
  methods: {
    // Tries to publish a new comment
    async publishComment() {
      let res = await fetch("http://localhost/api/comment.php?film_id=" + this.film_id + "&comment=" + encodeURIComponent(this.new_comment), {
        credentials: 'include'
      });
      res = await res.json();
      if (res.status == false) {
        // User not logged
        this.snackbar_show_error = true;
      } else {
        // Comment success
        this.new_comment = null;
        window.location.reload()
      }
    },
    // Tries to place a new vote
    async voteFilm() {
      this.snackbar_show = true
      let res = await fetch("http://localhost/api/rate.php?film_id=" + this.film_id + "&score=" + this.new_film_rating, {
        credentials: 'include'
      });
      res = await res.json();
      if (res.status == false) {
        // User not logged in
        this.snackbar_show_error = true;
      } else {
        // Vote success
        this.snackbar_show = true
      }
      // Starts recommendation process in the server
      fetch("http://localhost/matlabServerInvoker.php", {
        credentials: 'include'
      });
    },
    // Get film cover 
    getFilmImgUrl(image) {
        try {
          return require('../images/films/' + image)
        } catch (e) {
            e.name
        }
    },
    // Get user profile image for the comments 
    getProfileImgUrl(image) {
        try {
          return require('../images/profiles/' + image)
        } catch (e) {
          return require("../images/placeholders/placehoder_profile.png")
        }
    },
  }
};
</script>