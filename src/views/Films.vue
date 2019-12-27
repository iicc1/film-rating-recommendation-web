<template>
  <v-container class="my-5">
    <v-text-field
        hide-details
        label="Search"
        prepend-inner-icon="mdi-magnify"
        solo-inverted
        append-icon="mdi-dots-vertical"
      >

      </v-text-field>
      

    <v-layout row wrap>
      <v-flex xs12 sm4 md3 lg2 v-for="film in films" :key="film.id">
        <v-card raised class="text-xs-center ma-3">
          <v-img :src="getImgUrl(film.url_pic)" height="200px"></v-img>

          <v-card-title>
            {{ film.title }}
          </v-card-title>
          <v-card-subtitle>
            <br>
            <v-row>
              <v-col style="margin: 8px">
                {{ rating }}
            </v-col>
              <v-col>
              <v-rating
                v-model="rating"
                background-color="purple lighten-3"
                color="purple"
                half-increments
                hover
                size="20"
              ></v-rating>
            </v-col>
            </v-row>
          </v-card-subtitle>

          <v-card-actions>
            <v-btn text>Explore</v-btn>
            <v-btn color="purple" text link :href="film.url_imdb" target="_blank">
              IMDB
            </v-btn>

            <v-spacer></v-spacer>

            <v-btn icon @click="show = !show">
              <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
            </v-btn>
          </v-card-actions>

          <v-expand-transition>
            <div v-show="show">
              <v-divider></v-divider>
              <v-card-text>
                {{ film.desc }}
                Premiere: {{ film.date }}
              </v-card-text>
            </div>
          </v-expand-transition>
        </v-card>
     </v-flex>
    </v-layout>
  </v-container>
</template>

<script>

export default {
  name: 'Films',

  data() {
    return {
      show: false,
      isActive: false,
      rating: 4.5,
      films: []
    }
  },
  mounted: async function () {
    const res = await fetch("http://localhost/api/films.php");
    let films = await res.json();
    this.films = films[0];
    //this.films = [{"id":"1","title":"Toy Story (1995)","date":"1995-01-01","url_imdb":"http://us.imdb.com/M/title-exact?Toy%20Story%20(1995)","url_pic":"MV5BMTgwMjI4MzU5N15BMl5BanBnXkFtZTcwMTMyNTk3OA@@._V1_SX300.jpg","desc":"A cowboy doll is profoundly threatened and jealous when a new spaceman figure supplants him as top toy in a boy's room."},{"id":"2","title":"GoldenEye (1995)","date":"1995-01-01","url_imdb":"http://us.imdb.com/M/title-exact?GoldenEye%20(1995)","url_pic":"MV5BMzk2OTg4MTk1NF5BMl5BanBnXkFtZTcwNjExNTgzNA@@._V1_SX300.jpg","desc":"James Bond teams up with the lone survivor of a destroyed Russian research center to stop the hijacking of a nuclear space weapon by a fellow agent believed to be dead."},{"id":"3","title":"Four Rooms (1995)","date":"1995-01-01","url_imdb":"http://us.imdb.com/M/title-exact?Four%20Rooms%20(1995)","url_pic":"MV5BMTQwOTMzNjA0Nl5BMl5BanBnXkFtZTcwMjgzNTUyMQ@@._V1_SX300.jpg","desc":"Four interlocking tales that take place in a fading hotel on New Year's Eve."}]
    // mas de 25 caracters, poner "..."
    // Regex that removes the date from the title
    for (let i in this.films) {
      //this.films[i].title = this.films[i].title.replace(/\(\d+\)/g, '')
      //if (i > 10) this.films.pop();
      //this.films[i].date = this.films[i].date.match('d+')
      this.films[i].title = this.films[i].title.substring(0, 23)
    }

  },
  methods: {
    getImgUrl(image) {
      try {
        return require('../images/' + image)
      } catch (e) {
          e.name
      }
    }
  }
};
</script>