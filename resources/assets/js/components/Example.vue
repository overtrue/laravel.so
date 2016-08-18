<template>
  <div class="container">
    <div class="content">
      <div class="title">{{ msg }}</div>
    </div>
  </div>
</template>

<script>
  export default{
    data () {
      return {
        msg: 'Vue 2.0 + Laravel 5'
      }
    }
  }
</script>

<style>
  html, body {
    height: 100%;
  }

  body {
    margin: 0;
    padding: 0;
    width: 100%;
    display: table;
    font-weight: 100;
    font-family: 'Lato';
  }

  .container {
    text-align: center;
    display: table-cell;
    vertical-align: middle;
  }

  .content {
    text-align: center;
    display: inline-block;
  }

  .title {
    font-size: 96px;
  }
</style>
