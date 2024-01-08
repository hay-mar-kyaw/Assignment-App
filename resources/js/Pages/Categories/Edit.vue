<template>
    <Layout>
        <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
            <Link href="/admin/categories" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">

                Categories
            </Link>
            </li>

            <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Edit Category</span>
            </div>
            </li>
        </ol>
        </nav>

        <div class="w-full bg-indigo-300 p-3 my-3 rounded-t-lg ">
            Edit Category
        </div>
        <!-- Category Create Form -->
        <form @submit.prevent="updateCategory" class="max-w-sm ">
            <div class="mb-5">
                <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                <input type="text" id="text" v-model="form.name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Input Name" required>
            </div>
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Category Photo</label>
                <p class="text-xs mb-2 text-gray-400">Recommended Size 400*200</p>
                <div class="mb-3">
                    <img :src="photo" alt="">
                </div>
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="dropzone-file" type="file" @input="form.photo = $event.target.files[0]"  class="hidden" />
                    </label>
                </div>



            </div>

            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
            <div class="flex items-start mb-5">

                <div class="flex items-center h-5">
                <input v-model="form.status" id="terms" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300">
                </div>
                <label for="terms" class="ms-2 text-sm font-medium text-gray-900">Publish</label>
            </div>
            <div class="mb-2">
                <button type="button" class="text-indigo-700 hover:text-white border border-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Cancel</button>
                <button type="submit" class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update</button>
            </div>

        </form>
    </Layout>
</template>

<script setup>
import {useForm,Link,router} from '@inertiajs/vue3'
import Layout from './../Components/Layout.vue'


const props=defineProps({
    category:Object,
    photo:String
})

const form=useForm({
    name:props.category.name,
    photo:null,
    status:props.category.status
})

const updateCategory = () =>{
    router.post(`/admin/categories/${props.category.id}`, {
    _method: 'put',
    name: form.name,
    photo:form.photo,
    status:form.status
})
}
</script>

<style lang="scss" scoped>

</style>
