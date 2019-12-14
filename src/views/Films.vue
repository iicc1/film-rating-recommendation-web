<template>
  <v-container class="my-5">
    <v-layout row wrap>
      <v-flex xs9 sm4 md3 lg2 v-for="person in team" :key="person.name">
        <v-card raised class="text-xs-center ma-3">
          <v-img src="https://www.elindependiente.com/wp-content/uploads/2019/09/zentauroepp47949887-mas-periodico-serie-chernobyl-hbo190503115003-1556877153367.jpg" height="200px"></v-img>

          <v-card-title>
            Chernobyl (miniseries)
          </v-card-title>

          <v-card-subtitle>
            Drama
          </v-card-subtitle>

          <v-card-actions>
            <v-btn text>Share</v-btn>
            <v-btn color="purple" text>
              Explore
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
                In April 1986, an explosion at the Chernobyl nuclear power plant in the Union of Soviet Socialist Republics becomes one of the world's worst man-made catastrophes. 
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
      team: [
        { name: 'The Net Ninja', role: 'Web developer' },
        { name: 'Ryu', role: 'Graphic designer' },
        { name: 'Chun Li', role: 'Web developer' },
        { name: 'Gouken', role: 'Social media maverick' },
        { name: 'Yoshi', role: 'Sales guru'}

      ]
    }
  }
};
</script>