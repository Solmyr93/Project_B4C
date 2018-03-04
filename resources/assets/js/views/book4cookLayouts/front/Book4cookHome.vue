<template>
    <section class="section section-hero-area container">
            <ul v-if="isLogged" class="tab-list">
                <li class="tab-button"
                    :class="{'active-tab': tabFlag === 'all'}"
                    @click="changeTab('all')" >Przepisy</li>
                <li class="tab-button"
                    :class="{'active-tab': tabFlag === 'liked'}"
                    @click="changeTab('liked')">Ulubione przepisy</li>
                <li class="tab-button"
                    :class="{'active-tab': tabFlag === 'my'}"
                    @click="changeTab('my')">Twoje przepisy</li>
            </ul>
          <hr class="sep-line">
          <div class="section section-of-recepies">
            <div class="row">
              <div class="col-lg-3">
                <input-text type="text"
                            name="search"
                            class="form-control"
                            placeholder="Wyszukaj po nazwie"
                            v-model="searchRecepie">
                </input-text>
              </div>
              <div class="col-lg-3">
                  <v-select class="select-background"
                            :options="recepieCategories"
                            :onChange="onChangeCategory"
                            placeholder="Wybierz kategorię">
                  </v-select>
              </div>
              <div class="col-lg-3">
                  <v-select class="select-background"
                            :options="recepieTags"
                            :onChange="onChangeTags"
                            placeholder="Wybierz tag"
                            multiple>
                  </v-select>
              </div>
              <div class="col-lg-3">
                  <button type="button"
                          class="btn btn-search"
                          @click="sort">
                          <i class="fa fa-search"></i>
                           Szukaj
                 </button>
              </div>
            </div>
            <recepies-list :page="page"
                           :start="listOfRecepies.listStart"
                           :stop="listOfRecepies.listStop">
            </recepies-list>
            <pages-list :active="listOfRecepies.active"
                        :stop="listOfRecepies.lastPage"
                        :items="listOfRecepies.listItems"
                        @changeActive="listOfRecepies.active = $event"
                        @changeStart="listOfRecepies.listStart = $event"
                        @changeStop="listOfRecepies.listStop = $event">
            </pages-list>
        </div>
    </section>
</template>

<script>

import RecepiesList from '../partials/RecepiesList.vue'
import PagesList from '../partials/PagesList.vue'
import InputText from '../inputs/InputText.vue'
import Ss from '../../../services/ss'

export default {
    props:{
        categories:{
            type: Array,
            required: true,
        },
        tags:{
            type: Array,
            required: true,
        },
        isLogged:{
            type: Boolean,
            required: false,
        },
    },
    components:{
        RecepiesList,
        PagesList,
        InputText,
    },
    data() {
        return{
            recepiesBuffor: [],
            recepies: [],
            listOfRecepies: {
                active: 1,
                lastPage: 0,
                listItems: 10,
                listStart: 0,
                listStop: 9,
            },
            category: null,
            tagsIn: [],
            tagsSorted: [],
            searchRecepie: "",
            tabFlag: "all",
            user: {
              favoriteRecipes: [],
              myRecipes: [],
            },
            firstloadFlag: false,
        }
    },
    computed:{
      recepieCategories(){
        let categoriesTab = [];

        for(let i = 0; i<this.categories.length; i++){
            categoriesTab[i] = this.categories[i].name;
        }

        return categoriesTab;
      },
      recepieTags(){
        let tagsTab = [];

        for(let i = 0; i<this.tags.length; i++){
          const label =  this.tags[i].name;
          const value =  this.tags[i].id;

          tagsTab.push({label,value});
        }

        return tagsTab;
      },
      page(){
          let recepiesTab = [];

          recepiesTab = this.recepiesBuffor;

          if(Math.floor(recepiesTab.length/this.listOfRecepies.listItems) === recepiesTab.length/this.listOfRecepies.listItems){
              this.listOfRecepies.lastPage = Math.floor(recepiesTab.length/this.listOfRecepies.listItems);
          }else{
              this.listOfRecepies.lastPage = Math.floor(recepiesTab.length/this.listOfRecepies.listItems) + 1;
          }
          return recepiesTab;
      },
    },
    created() {
        let self = this;

        axios.get('/api/v1/recipes').then(function (response) {
            for(let i = 0; i < response.data.length; i++) {
                self.recepies.push({
                    id: response.data[i].id,
                    recepieName: response.data[i].name,
                    category: response.data[i].category.name,
                    autor: response.data[i].user.first_name +" "+ response.data[i].user.last_name,
                    rank: response.data[i].avg_rate,
                    tags: response.data[i].tags
                });
            }
            self.recepiesBuffor = self.recepies;
        })
        .catch(function (error) {
            toastr['error']('Nastąpił jakiś błąd', 'Error');
        });

        this.user.favoriteRecipes = Ss.get('auth.favorite_recipes');
        this.user.myRecipes = Ss.get('auth.my_recipes');
    },
    methods: {
        changeTab(value) {
            this.tabFlag = value;
            this.sort();
        },
        onChangeCategory(value){
            this.category = value;
        },
       onChangeTags(value){
            this.tagsIn = value;
            this.tagsSorted = [];

            for(let i = 0; i<this.tagsIn.length; i++){
                this.tagsSorted.push(this.tagsIn[i].value);
            }
            this.tagsSorted.sort(function(a,b){return a-b});
        },
        upDate(buff){
            let table = [];
            for(let i=0; i<buff.length; i++) table[i] = buff[i];
            return table;
        },
        sort(){
            let tableTooSort;

            tableTooSort = this.recepies;
            let i;

            if(this.tabFlag === "my"){
                let buff = [];
                if(!this.user.myRecipes || this.user.myRecipes === []){
                    tableTooSort = [];
                }
                else{
                    let j = 0;

                    for(i=0; i<tableTooSort.length; i++) {
                        if(tableTooSort[i].id === this.user.myRecipes[j]){
                            buff.push(tableTooSort[i]);
                            j++;
                        }
                    }
                    tableTooSort = this.upDate(buff);
                }
            }

            if(this.tabFlag === "liked"){
                let buff = [];
                if(!this.user.favoriteRecipes || this.user.favoriteRecipes === []){
                    tableTooSort = [];
                }
                else{
                    let j = 0;

                    for(i=0; i<tableTooSort.length; i++) {
                        if(tableTooSort[i].id === this.user.favoriteRecipes[j]){
                            buff.push(tableTooSort[i]);
                            j++;
                        }
                    }
                    tableTooSort = this.upDate(buff);
                }
            }

            if(this.tagsSorted.length > 0){
              let buff = [];
              for(let i=0; i<tableTooSort.length; i++) {
                  if(tableTooSort[i].tags !== []){
                      let k = 0;
                      for(let j=0; j<tableTooSort[i].tags.length; j++){
                          if(this.tagsSorted[k] < tableTooSort[i].tags[j].id){
                            j = tableTooSort[i].tags.length;
                          }else if(this.tagsSorted[k] === tableTooSort[i].tags[j].id){
                            k++;
                          }
                      }
                      if(k === this.tagsSorted.length){
                          buff.push(tableTooSort[i]);
                      }
                  }
              }
              tableTooSort = this.upDate(buff);
            }

            if(this.category){
                let buff = [];

                for(i=0; i<tableTooSort.length; i++) {
                    if(tableTooSort[i].category === this.category) buff.push(tableTooSort[i]);
                }
                tableTooSort = this.upDate(buff);
            }

            if(this.searchRecepie){
                let buff = [];

                for(i=0; i<tableTooSort.length; i++) {
                    if(tableTooSort[i].recepieName.includes(this.searchRecepie)) buff.push(tableTooSort[i]);
                }
                tableTooSort = this.upDate(buff);
            }

            this.listOfRecepies.active = 1;
            this.listOfRecepies.listStart = 0;
            this.listOfRecepies.listStop = 9;

            if(Math.floor(tableTooSort.length/this.listOfRecepies.listItems) === tableTooSort.length/this.listOfRecepies.listItems){
                this.listOfRecepies.lastPage = Math.floor(tableTooSort.length/this.listOfRecepies.listItems);
            }else{
                this.listOfRecepies.lastPage = Math.floor(tableTooSort.length/this.listOfRecepies.listItems) + 1;
            }

            this.recepiesBuffor = tableTooSort;
          },
    },
}
</script>
