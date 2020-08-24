<template>
    <div class="container">
       <button class="btn btn-warning btn-circle btn-sm pull-right"  v-on:click="logout" >Logout</button>
           <table class="table" id="firstTable">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="row in items">
      <td>{{row.name}}</td>
      <td>{{row.email}}</td>
      <td>
        <button class="btn btn-warning btn-circle btn-sm">edit</button>
        <button class="btn btn-danger btn-circle btn-sm">Delete</button>
      </td>
    </tr>
  </tbody>
</table>
<paginate
    :page-count="20"
    :page-range="3"
    :margin-pages="2"
    :click-handler="clickCallback"
    :prev-text="'Prev'"
    :next-text="'Next'"
    :container-class="'pagination'"
    :page-class="'page-item'">
  </paginate>
                   
    </div>
</template>

<script>
    export default {
         data: function() {
            return {
             
              items : [],
              token:''
            }
        },
        methods: {
            clickCallback: function(pageNum) {
      console.log(pageNum)
    },
            getusers() {
                axios.get('http://localhost/codeassignment/public/api/user',{
                  headers: {
                    'Authorization': 'Bearer '+this.$store.getters.gettoken,
                    'Accept' : 'application/json'
                  }
            }).then(resp => {
                let length = resp.data.data.length;
                for (let i =1; i< length ; i++) {
                this.items.push({
                    name : resp.data.data[i].name,
                    email : resp.data.data[i].email,
                }) 

                }
            });
            },
            logout() {
                this.$store.commit('setLogin', false)
                    this.$store.commit('setToken', '')
                    this.$router.push('/')
            }
        },
        mounted() {

            if (!this.$store.getters.getloginstate) {
                this.$router.push('/')
            } else {
                this.token = this.$store.getters.gettoken;
                this.getusers();

            }
      }
    }
</script>
