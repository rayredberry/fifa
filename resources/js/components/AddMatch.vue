<template>
    <form method="post" >

    <input type="hidden" name="_token" :value="csrf">

        <div class="">
            <select name="first_user_id">
                <!-- @foreach($users as $user) -->
                <option value="">

                </option>
                <!-- @endforeach -->
            </select>
            <input type="number" name="first_user_goal" placeholder="პირველის გოლი">
        </div>
        <div class="">
            <select name="second_user_id">
                <!-- @foreach($users as $user) -->
                <!-- <option v-for="user in users" value="">
                    {{user.name}}
                </option> -->
                <!-- @endforeach -->
            </select>
            <input type="number" name="second_user_goal" placeholder="მეორეს გოლი">
        </div>

        <input type="submit" value="დამატება">
    </form>
</template>

<script>

    export default {
        name: "add-match",
        // props: ['userData', 'action'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        mounted(){
            console.log(this.props);
        }
    }


</script>

<style scoped>

</style>
