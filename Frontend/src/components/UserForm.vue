<template>
<q-form @submit.prevent="onSubmit" ref="userForm" greedy>
  <q-input
    v-model="form.name"
    label="Name"
    :rules="[val => !!val || 'Name is required']"
  />

  <q-input
    v-model="form.email"
    label="Email"
    type="email"
    :rules="[
      val => !!val || 'Email is required',
      val => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) || 'Enter a valid email'
    ]"
  />

  <q-input
    v-model="form.phone_number"
    label="Phone"
    type="tel"
    :rules="[
      val => !val || /^[0-9]+$/.test(val) || 'Phone must be numeric'
    ]"
  />

  <q-input
    v-model="form.address"
    label="Address"
    :rules="[]"
  />

  <q-input
    v-model="form.age"
    label="Age"
    type="number"
    :rules="[
      val => !val || /^[0-9]+$/.test(String(val)) || 'Age must be a number'
    ]"
  />

  <q-file
    v-model="form.profile_picture"
    label="Profile Picture"
    filled
    :rules="[]"
  />

  <div class="q-mt-md">
    <q-btn label="Submit" type="submit" color="primary" />
  </div>
</q-form>
  </template>
  
  <script setup lang="ts">
  import { ref, defineProps, watch, nextTick } from 'vue'
  import { createUser, updateUser } from '@/services/UserService'
  import { Notify } from 'quasar'
  
  // Props: optional editUser and required callback onSaved
  const props = defineProps<{ editUser?: any; onSaved: () => void }>();
  const userForm = ref();

  // Initial form state
  const defaultForm = () => ({
    name: '',
    email: '',
    phone_number: '',
    address: '',
    age: '',
    profile_picture: null,
  })
  
  const form = ref(defaultForm())
  
  // Watch for editUser and populate form
  watch(
    () => props.editUser,
    (val) => {
      if (val) form.value = { ...defaultForm(), ...val }
    },
    { immediate: true }
  )
  
  const onSubmit = async () => {

    const valid = await userForm.value.validate()
    if (!valid) return 

    const data = new FormData()
    Object.entries(form.value).forEach(([key, value]) => {
      if (value !== null) data.append(key, value as string | Blob)
    })
  
    try {
      if (props.editUser) {
        await updateUser(props.editUser.id, data)
        Notify.create({ type: 'positive', message: 'User updated successfully!' })
        userForm.value.resetValidation();
      } else {
        console.log("run successfully");
        await createUser(data)
        Notify.create({ type: 'positive', message: 'User created successfully!' })
        form.value = defaultForm();
        await nextTick();
        userForm.value.resetValidation();
      }
  
      props.onSaved()
    } catch (err: any) {
      console.log(err);
      
      const errorMessage = err?.response?.data?.message || 'An unexpected error occurred.'
      Notify.create({ type: 'negative', message: errorMessage })
    }
  }
  </script>
  
  