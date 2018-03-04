<template>
    <section class="section register-box section-of-recepies">
        <form id="newRecipeForm"
              method="post">
            <div class="row add-recepie-container">
                <div class="col-lg-12">
                    <div class="row">
                        <h4 class="h4-new-recepie">Nazwa przepisu:</h4>
                        <div :class="{'form-group col-lg-6': true, 'has-danger': errors.has('name') }">

                        </div>
                        <span v-show="errors.has('name')"
                              class="help">
                              {{ errors.first('name') }}
                        </span>
                    </div>
                    <div class="row">
                        <h4 class="h4-new-recepie">Kategoria:</h4>
                        <div :class="{'form-group col-lg-6': true, 'has-danger': errors.has('category') }">

                        </div>
                        <span v-show="errors.has('category')"
                              class="help">
                              {{ errors.first('category') }}
                        </span>
                    </div>
                    <div class="row">
                        <h4 class="h4-new-recepie">Tagi:</h4>
                        <div :class="{'form-group col-lg-6': true, 'has-danger': errors.has('name') }">

                        </div>
                        <span v-show="errors.has('tag')"
                              class="help">
                              {{ errors.first('tag') }}
                        </span>
                    </div>
                    <div class="row">
                        <h4>Składniki:</h4>
                        <div class="col-lg-12 description-recepie">
                            <div :class="{'form-group': true, 'has-danger': errors.has('ingredients') }">

                               <div v-show="errors.has('ingredients')"
                                    class="help">
                                    {{ errors.first('ingredients') }}
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Przygotowanie:</h4>
                        <div class="col-lg-12 description-recepie">
                            <div :class="{'form-group': true, 'has-danger': errors.has('preparation') }">

                                <div v-show="errors.has('preparation')"
                                     class="help">
                                     {{ errors.first('preparation') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-sep">
                        <div class="col-lg-12">
                            <div class="col-lg-6 offset-lg-3">
                                <button class="btn btn-theme btn-full"
                                        type="button"
                                        @click="validateBeforeSubmit">
                                        Zapisz
                                </button>
                                <router-link class="btn btn-theme btn-full"
                                             to="/#">
                                             Strona głowna
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script>

import InputText from '../inputs/InputText.vue'
import InputTextArea from '../inputs/InputTextArea.vue'

export default {
    props: {
        categories: {
            type: Array,
            default: [],
        },
        tags: {
            type: Array,
            default: [],
        },
    },
    components: {
        InputText,
        InputTextArea,
    },
    data() {
        return {
            tag: "",
            recipeData: {
                name: "",
                category: "",
                ingredients: "",
                preparation: "",
                tags:[],
            }
        }
    },
    methods: {
       validateBeforeSubmit(e){
            this.$validator.validateAll().then(result => {
                if (!result){
                    alert('Potraw Błędy!');
                }
            });
        },
    },
}
</script>
