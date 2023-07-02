<?php 
    require "header.php";
    if (!isset($_SESSION["userid"])) {
        exit();
    }
?>
<link rel="stylesheet" href="cssfolder/profileDetails.css">


<main id ="main">
    <a href="profile.php">< Account</a>
    <h1>პროფილი</h1>
    <div class ="parentDiv first">
        <div class ="titles">{{ username }}</div>
        <div>
            <img src="images/defaulti.png" alt="Profile picture">
            <p>სურათის ატვირთვა</p>
        </div>
    </div>
    <hr>
    <div class ="parentDiv">
        <div class ="titles">
            <div> 
                <p>სახელი</p>
                <p v-if="!toggleUser">{{ name }}</p>
            </div>
            <div>
            <span v-on:click="toggleUser=!toggleUser">Edit</span>
            </div>
        </div>
        <div class ='submitChanges'>
        <input v-model="name" v-if="toggleUser" type="text">
        <button v-on:click="updateUserData('toggleUser')" v-on:click="toggleUser=!toggleUser" v-if="toggleUser">შენახვა</button>
        </div>
    </div>
    <hr>
    <div class ="parentDiv">
        <div class ="titles">
            <div> 
                <p>მეილი</p>
                <p v-if="!toggleEmail">{{ email }}</p>
            </div>
            <div>
            <span v-on:click="toggleEmail=!toggleEmail">Edit</span>
            </div>
        </div>
        <div class ='submitChanges'>
            <input v-model="email" v-if="toggleEmail" type="text">
            <button v-on:click ="updateUserData('toggleEmail')" v-on:click="toggleEmail=!toggleEmail" v-if="toggleEmail">შენახვა</button>
        </div>
    </div>
    <hr>
    <div class ="parentDiv">
        <div class ="titles">
            <div> 
                <p>პირობითი სახელი</p>
                <p v-if="!toggleUsername">{{ username }}</p>
            </div>
            <div>
            <span v-on:click="toggleUsername=!toggleUsername">Edit</span>
            </div>
        </div>
        <div class ='submitChanges'>
            <input v-model="username" v-if="toggleUsername" type="text">
            <button v-on:click ="updateUserData('toggleUsername')" v-if="toggleUsername">შენახვა</button>
        </div>
    </div>
    <hr>
</main>

<script src="https://unpkg.com/vue@3.2.21/dist/vue.global.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
<script>
const app = Vue.createApp({
    data() {
        return {
            name: "",
            email: "",
            username: "",
            toggleUser: false,
            toggleEmail: false,
            toggleUsername: false
        }
    },
    mounted() {
    this.fetchSessionData();
    },
    methods: {
        fetchSessionData() {
            axios.get('includes/vueProfileData/session.inc.php', {
                cache: false
                })
                .then(response => {
                    const sessionData = response.data;
                    this.name = sessionData.username;
                    this.email = sessionData.usermail;
                    this.username = sessionData.userUid;
                })
                .catch(error => {
                    console.error(error);
                })
        },
        updateUserData(toggleData) {
            const requestData = {
                name: this.name,
                email: this.email,
                username: this.username
            }
            axios.post('includes/vueProfileData/updateUserData.php', requestData)
            .then(response => {
            console.log(response.data);
            })
            .catch(error => {
                console.error(error);
            });

            switch(toggleData) {
                case 'toggleUsername':
                    this.toggleUsername = !this.toggleUsername;
                    break;
                case 'toggleUser':
                    this.toggleUser = !this.toggleUser;
                    break;
                case 'toggleEmail':
                    this.toggleEmail = !this.toggleEmail;
                default:
                    break;
            }

            this.fetchSessionData();
        }
    }
})
app.mount("#main");
</script>
<?php require "footer.php"; ?>