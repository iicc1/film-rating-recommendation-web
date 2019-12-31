<template>
  <v-container class="ma-10">
    <v-row no-gutters>
      <template >
        <v-col>
          <v-img :src="getImgUrl(film_data.url_pic)" height="400px" width="400px"></v-img>
        </v-col>
        <v-col>
          <v-list>
            <v-subheader>FILM DATA</v-subheader>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Title</v-list-item-title>
                <v-list-item-subtitle>{{ film_data.title }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-list-item two-line>
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
          <v-list-item v-for="comment in film_comments" :key="comment.id">
            <v-list-item-avatar>
              <v-img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Vue.js_Logo_2.svg/1200px-Vue.js_Logo_2.svg.png"></v-img>
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
      value=""
    ></v-textarea>
    
    <v-btn block @click="publish()">PUBLISH</v-btn>
  </v-container>
</template>

<script>

export default {
  name: 'Film',
  data: () => ({
    film_id: null,
    film_data: null,
    film_comments: null
  }),
  async mounted () {
    const film_id = this.$route.query.id;
    let res = await fetch("http://localhost/api/film.php?id=" + film_id, {
      credentials: 'include'
    });
    res = await res.json();
    this.film_data = res.movie;
    this.film_comments = res.comments;
  },
  methods: {
    test () {
      // eslint-disable-next-line no-console
      console.log(this.film_data)
    },
    getImgUrl(image) {
        try {
          return require('../images/films/' + image)
        } catch (e) {
            e.name
        }
      }
  }
};
</script>