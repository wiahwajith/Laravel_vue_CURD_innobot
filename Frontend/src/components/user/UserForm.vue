<template>
  <q-form @submit.prevent="onSubmit" ref="userForm" greedy>
    <q-input v-model="form.name" label="Name" :rules="rules.name" />

    <q-input
      v-model="form.email"
      label="Email"
      type="email"
      :rules="rules.email"
    />

    <q-input
      v-model="form.phone_number"
      label="Phone"
      type="tel"
      :rules="rules.phone"
    />

    <q-input v-model="form.address" label="Address" />

    <q-input
      v-model="form.age"
      label="Age"
      type="number"
      :rules="rules.age"
    />

    <q-file
      v-model="form.profile_picture"
      label="Profile Picture"
      filled
    />

    <div v-if="props.editUser && !form.profile_picture" class="q-mt-sm">
      <q-img
        :src="getProfilePictureUrl(props.editUser.profile_picture)"
        spinner-color="primary"
        style="max-width: 150px; border-radius: 8px"
      />
      <div class="text-caption q-mt-xs">
        Existing file: {{ props.editUser.profile_picture }}
      </div>
    </div>

    <div class="q-mt-md">
      <q-btn label="Submit" type="submit" color="primary" />
    </div>
  </q-form>
</template>

<script setup lang="ts">
import { ref, defineProps, watch, nextTick } from 'vue'
import { Notify } from 'quasar'
import { createUser, updateUser } from '@/services/UserService'
import { getProfilePictureUrl } from '@/utils/helpers'

interface FormDataType {
  name: string
  email: string
  phone_number: string
  address: string
  age: string | number
  profile_picture: File | null
}

const props = defineProps<{
  editUser?: any
  onSaved: () => void
}>()

const userForm = ref()
const form = ref<FormDataType>(getDefaultForm())

const rules = {
  name: [(val: string) => !!val || 'Name is required'],
  email: [
    (val: string) => !!val || 'Email is required',
    (val: string) =>
      /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) || 'Enter a valid email',
  ],
  phone: [
    (val: string) =>
      !val || /^[0-9]+$/.test(val) || 'Phone must be numeric',
  ],
  age: [
    (val: string | number) =>
      !val || /^[0-9]+$/.test(String(val)) || 'Age must be a number',
  ],
}

function getDefaultForm(): FormDataType {
  return {
    name: '',
    email: '',
    phone_number: '',
    address: '',
    age: '',
    profile_picture: null,
  }
}

watch(
  () => props.editUser,
  (val) => {
    if (val) {
      const copy = { ...getDefaultForm(), ...val }
      copy.profile_picture = null
      form.value = copy
    }
  },
  { immediate: true }
)

const onSubmit = async () => {
  const valid = await userForm.value?.validate()
  if (!valid) return

  const data = prepareFormData()

  try {
    if (props.editUser) {
      await updateUser(props.editUser.id, data)
      Notify.create({ type: 'positive', message: 'User updated successfully!' })
    } else {
      await createUser(data)
      Notify.create({ type: 'positive', message: 'User created successfully!' })
      form.value = getDefaultForm()
      await nextTick()
    }

    userForm.value?.resetValidation()
    props.onSaved()
  } catch (err: any) {
    console.error(err)
    const errorMessage = err?.response?.data?.message || 'An unexpected error occurred.'
    Notify.create({ type: 'negative', message: errorMessage })
  }
}

function prepareFormData(): FormData {
  const data = new FormData()

  Object.entries(form.value).forEach(([key, value]) => {
    if (value !== null) {
      data.append(key, value as string | Blob)
    }
  })

  if (
    props.editUser &&
    !form.value.profile_picture &&
    props.editUser.profile_picture
  ) {
    data.append('existing_profile_picture', props.editUser.profile_picture)
  }

  return data
}
</script>

<style scoped>
/* Optional: Custom styling if needed */
</style>
