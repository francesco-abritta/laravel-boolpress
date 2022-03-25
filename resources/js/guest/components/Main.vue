<template>
  <div>
      <ul>
        <li v-for="(post, index) in posts" :key="index">
          <div>TITOLO: {{post.title}}</div>
          <div>CONTENUTO: {{post.content}}</div>
        </li>
      </ul>
  </div>
</template>

<script>
export default {
    name: "Main",
    data() {
      return {
        posts: [],
      };
    },
    created(){
        axios
        .get("/api/posts")
        .then((apirisp)=>{
            this.posts= apirisp.data;
            console.log(this.posts);
        })
    }
};
</script>

<style scoped>
  ul{
    list-style: none;
  }
  li{
    margin-bottom: 20px;
  }
</style>