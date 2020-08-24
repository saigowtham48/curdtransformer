<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                         <p>
                        <router-link to="/login" class="pull-left">
                        <button  class="btn btn-primary">Login!</button>
                    </router-link>
                        <router-link to="/register"   class="pull-right"><button  class="btn btn-primary">Register!</button></router-link>
                    </p>
                    </div>

                    <div class="card-body">
                        <div class="title m-b-md">
                            <span style="color: black"><b>
                            Vue Js + Laravel</b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
     data(){
       return{
         myStyle:{
            backgroundColor:"blue" 
            }
          
           }
         },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
