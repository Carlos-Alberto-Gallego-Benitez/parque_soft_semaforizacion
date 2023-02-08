<template>
    <main>
        <section id="about" class="about">
            <div class="container-fluid">
                <div class="">
                    <div class="card-body">
                        <div class="row content">
                            <div class="col-md-12" data-aos="fade-right">
                                <img src="../assets/img/dashboard/1920.png" class="img-fluid" alt="">
                                <div class="text-center mt-2"><h3></h3></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>
<script>
import {mapState} from "vuex";
export default {
  computed : mapState(['is_logged', 'user']),
}
</script>

