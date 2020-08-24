<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>
                        <h4>Log in</h4></b></div>

                    <div class="card-body">
                        <div class="login-form">
                            
                                <h2 class="text-center"></h2>       
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="name" v-model="name" required="required">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password" v-model="password" required="required">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Log in</button>
                                </div>
                                       
                            
                            <router-link to="/register"   class="pull-right"><button  class="btn btn-secondary">Register!</button></router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.login-form {
    width: 340px;
    margin: 50px auto;
    font-size: 15px;
}
.login-form form {
    margin-bottom: 15px;
    background: #f7f7f7;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    padding: 30px;
}
.login-form h2 {
    margin: 0 0 15px;
}
.form-control, .btn {
    min-height: 38px;
    border-radius: 2px;
}
.btn {        
    font-size: 15px;
    font-weight: bold;
}
</style>
<script>
    export default {
         data: function() {
            return {
             
              name: '',
              password: ''
            }
        },
      methods: {
        submitted() {
          this.isSubmitted = true;
        }
      },
     mounted() {
            console.log('Component mounted fdfdfd.')
        }
    }
</script>
