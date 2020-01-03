<template>
  <v-container class="ma-5 pa-5">
    <v-row>
      <template>
        <v-col md="auto">
          <v-img :src="getFilmImgUrl(film_data.url_pic)" height="389px" width="389px" style="border-radius: 1%"></v-img>
        </v-col>
        <v-col >
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
  </v-container>
</template>

<script>

export default {
  name: 'Film',
  data: () => ({
    film_id: null,
    film_data: [],
    film_comments: [],
    new_comment: null,
    rules: [v => v.length <= 400 || 'Max 400 characters'],
  }),
  async created() {
    this.film_id = this.$route.query.id;
    let res = await fetch("http://localhost/api/film.php?id=" + this.film_id, {
      credentials: 'include'
    });
    res = await res.json();
    this.film_data = res.movie;
    this.film_comments = res.comments;
    // eslint-disable-next-line no-console
    console.log(this.film_comments)
  },
  methods: {
    async publishComment() {
      // eslint-disable-next-line no-console
      console.log(this.new_comment)
      let res = await fetch("http://localhost/api/comment.php?film_id=" + this.film_id + "&comment=" + encodeURIComponent(this.new_comment), {
        credentials: 'include'
      });
      res = await res.json();
      // eslint-disable-next-line no-console
      console.log(res)
      // if todo ok
      this.new_comment = null;
      window.location.reload()
    },
    getFilmImgUrl(image) {
        try {
          return require('../images/films/' + image)
        } catch (e) {
            e.name
        }
    },
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