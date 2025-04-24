<script setup lang="ts">
import { RouterView } from 'vue-router'
</script>

<template>
  <q-layout view="lHh Lpr lFf">
    <q-page-container>
      <q-page class="q-pa-md">
        <!-- Router View renders page content here -->
        <RouterView />
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<style scoped>
</style>
