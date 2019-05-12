<template>
  <div class="container has-background-white-bis">
    <div class="line has-background-success"></div>
    <div class="contents">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
.container {
  margin-top: -3em;
  width: 60vw;
  box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 0.75);
}

.line {
  height: 0.5em;
}

.contents {
  padding: 3em;
}
</style>
