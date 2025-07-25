<script setup lang="ts">
import { Destination, Testimonial } from '@/types';
import { ref, computed, onMounted } from 'vue';
import { Link, Head } from '@inertiajs/vue3';
import Footer from '@/components/landing/Footer.vue';
import Navbar from '@/components/landing/Navbar.vue';
import DestinationCard from '@/components/landing/DestinationCard.vue';
import ReviewCard from '@/components/landing/ReviewCard.vue';
import ReviewForm from '@/components/landing/ReviewForm.vue';
import { useLocation } from '@/composables/useLocation';
import { Button } from '@/components/ui/button';

// Define props for data passed from the controller
const props = defineProps({
    destination: {
        type: Object as () => Destination,
        default: () => ({})
    },
    nearbyDestinations: {
        type: Array as () => Destination[],
        default: () => []
    },
    testimonials: {
        type: Array as () => Testimonial[],
        default: () => []
    }
});

// Use the location composable
const { getUserLocation, locationStatus } = useLocation();

// Computed property to determine if address should be shown instead of distance
const shouldShowAddress = computed(() => {
    return locationStatus.value === 'denied' || locationStatus.value === 'unsupported';
});

// Dummy data for destination details
const dummyDestination = ref({
    id: 1,
    name: 'Tahura Sultan Adam',
    thumb_image: 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80',
    content: 'Tahura Sultan Adam adalah kawasan konservasi alam yang terletak di Kalimantan Selatan, Indonesia. Taman Hutan Raya (Tahura) ini memiliki luas lebih dari 112.000 hektare, mencakup berbagai ekosistem seperti hutan hujan tropis, perbukitan, dan sungai yang indah. Sebagai destinasi wisata alam, Tahura Sultan Adam menawarkan berbagai aktivitas menarik seperti trekking, camping, dan menikmati pemandangan alam yang masih asri.',
    facility: 'Pengawasan 24 Jam, Keamanan Terjaga, Kenyamanan Dijamin, Villa & Penginapan, Mobil Bisa Masuk',
    lat: -3.4433238,
    lon: 114.7446383,
    operating_hours: 'Buka Pukul 05.00 - 16.00',
    address: 'Cempaka, Kec. Cemp., Kota Banjar Baru, Kalimantan Selatan 70661',
    avg_rating: 5.0,
    total_reviews: 2,
    published: true,
});

// Dummy data for testimonials
const dummyTestimonials = ref([
    {
        id: 1,
        name: 'Budi Santoso',
        rating: 5,
        comment: 'Saya sangat menikmati perjalanan kesini! Suasananya masih sangat alami dengan udara yang sejuk dan pemandangan hutan yang indah. Saya mengunjungi Menara Pandang Mandiangin, dan dari atas saya bisa melihat hamparan hutan yang luas, benar-benar memanjakan mata. Trekking ke air terjun juga seru, meskipun medannya cukup menantang. Cocok untuk pecinta alam dan fotografi!',
    },
]);

const capitalizeFirstLetter = (str: string) => {
    return str.charAt(0).toUpperCase() + str.slice(1);
};

// Use data from props or dummy data
const destinationData = computed(() => Object.keys(props.destination).length > 0 ? props.destination : dummyDestination.value);
const testimonialsList = computed(() => props.testimonials.length > 0 ? props.testimonials : dummyTestimonials.value);

// Format facilities as array
const facilities = computed(() => {
    if (typeof destinationData.value.facility === 'string') {
        return destinationData.value.facility.split(',').map(item => item.trim());
    }
    return [];
});

// Modal state
const showReviewModal = ref(false);

onMounted(() => {
    // Request user location on page load
    getUserLocation(['nearbyDestinations']);
});
</script>

<template>
    <Head :title="destinationData.name">
        <!-- Google font poppins -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    </Head>

    <div class="min-h-screen flex flex-col bg-white text-gray-800 font-['Poppins']">
        <!-- Navigation Bar -->
        <Navbar activePage="catalog" />

        <!-- Main Content -->
        <section class="py-6 md:py-8 lg:py-10 px-4 md:px-6">
            <div class="container lg:max-w-4/5 mx-auto">
                <!-- Destination Header Section -->
                <div class="flex flex-col lg:flex-row gap-4 md:gap-5">
                    <!-- Main Image -->
                    <div class="w-full lg:w-1/2 rounded-2xl overflow-hidden h-[250px] sm:h-[320px] md:h-[380px] lg:h-[450px]">
                        <img :src="destinationData.thumb_image" alt="Destination" class="w-full h-full object-cover rounded-2xl">
                    </div>

                    <!-- Destination Info -->
                    <div class="w-full lg:w-1/2 flex flex-col gap-3">
                        <div class="flex justify-between items-center">
                            <h1 class="text-2xl sm:text-3xl md:text-4xl font-semibold">{{ destinationData.name }}</h1>
                            <div class="flex gap-2">
                                <Button variant="landing" class="p-1.5 md:p-2">
                                    <img src="/images/icons/export.svg" alt="Share" class="w-4 h-4 md:w-5 md:h-5" />
                                </Button>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5">
                            <img src="/images/icons/medal-star-primary.svg" alt="Rating" class="w-5 h-5 md:w-6 md:h-6 lg:w-7 lg:h-7" />
                            <span class="text-lg sm:text-xl md:text-2xl font-semibold text-primary">{{ destinationData.avg_rating }}</span> ({{ destinationData.total_reviews }} Ulasan)
                        </div>

                        <div class="flex flex-col gap-3 md:gap-4 mt-3 md:mt-4">
                            <!-- Opening Hours -->
                            <div class="flex items-center gap-2 md:gap-3">
                                <img src="/images/icons/clock.svg" alt="Clock" class="w-5 h-5 md:w-6 md:h-6" />
                                <span class="text-base sm:text-lg md:text-xl text-gray-600">{{ destinationData.operating_hours || "Buka Pukul 05.00 - 16.00" }}</span>
                            </div>

                            <!-- Address -->
                            <div class="flex items-center gap-2 md:gap-3">
                                <img src="/images/icons/location.svg" alt="Location" class="w-5 h-5 md:w-6 md:h-6" />
                                <span class="text-base sm:text-lg md:text-xl text-gray-600">{{ destinationData.address || "Cempaka, Kec. Cemp., Kota Banjar Baru, Kalimantan Selatan 70661" }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="mt-5 md:mt-6">
                    <div class="text-base sm:text-lg md:text-xl text-gray-600 text-justify" v-html="destinationData.content">
                    </div>
                </div>
            </div>
        </section>

        <!-- Facilities and Map Section -->
        <section class="py-6 md:py-8 lg:py-10 px-4 md:px-6">
            <div class="container lg:max-w-4/5 mx-auto flex flex-col lg:flex-row gap-6">
                <!-- Map Section -->
                <div class="w-full lg:w-1/2">
                    <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-semibold mb-3">Peta</h2>
                    <div class="rounded-2xl overflow-hidden h-[250px] md:h-[300px] lg:h-[350px] w-full shadow-lg">
                        <iframe 
                            width="100%" 
                            height="100%" 
                            style="border:0" 
                            loading="lazy" 
                            allowfullscreen 
                            :src="`https://www.google.com/maps/embed/v1/place?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&q=${destinationData.lat},${destinationData.lon}`">
                        </iframe>
                    </div>
                </div>

                <!-- Facilities Section -->
                <div class="w-full lg:w-1/2 mt-6 lg:mt-0">
                    <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-semibold mb-3 md:mb-4">Fasilitas</h2>
                    <div class="grid grid-cols-1 gap-3">
                        <div v-for="(facility, index) in facilities" :key="index" class="flex items-center gap-2">
                            <!-- <img :src="`/images/icons/${getFacilityIcon(facility)}.svg`" alt="Facility" class="w-5 h-5 md:w-6 md:h-6" /> -->
                            <span class="text-base sm:text-lg md:text-xl text-gray-600">{{ capitalizeFirstLetter(facility) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- User Reviews Section -->
        <section class="py-6 md:py-8 lg:py-10 px-4 md:px-6">
            <div class="container lg:max-w-4/5 mx-auto">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-5">
                    <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-semibold mb-3 sm:mb-0">Ulasan Pengguna</h2>
                    <Button 
                        @click="showReviewModal = true" 
                        variant="landing"
                        class="flex items-center gap-1.5 px-3 md:px-4 py-1.5 md:py-2"
                    >
                        <img src="/images/icons/add-circle.svg" alt="Add" class="w-4 h-4 md:w-5 md:h-5" />
                        <span class="text-base md:text-lg">Beri Ulasan</span>
                    </Button>
                </div>

                <!-- Reviews List -->
                <div class="flex flex-col gap-3 md:gap-4">
                    <ReviewCard 
                        v-for="testimonial in testimonialsList" 
                        :key="testimonial.id"
                        :id="testimonial.id"
                        :name="testimonial.name || 'Anonymous'"
                        :rating="testimonial.rating"
                        :comment="testimonial.comment"
                    />
                </div>
            </div>
        </section>

        <!-- Review Form Component -->
        <ReviewForm 
            v-model:open="showReviewModal"
            :destinationId="Number(destinationData.id)"
        />

        <!-- Recommended Destinations Section -->
        <section class="py-6 md:py-8 lg:py-10 px-4 md:px-6">
            <div class="container lg:max-w-4/5 mx-auto">
                <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-semibold text-center mb-4 md:mb-6">Rekomendasi Wisata</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5 lg:gap-6">
                    <DestinationCard 
                        v-for="destination in props.nearbyDestinations" 
                        :key="destination.id"
                        :id="destination.id"
                        :name="destination.name"
                        :thumbImage="destination.thumb_image"
                        :rating="destination.avg_rating || 0"
                        :distance="destination.distance ? `${destination.distance} Km` : '-'"
                        :address="destination.address || ''"
                        :showAddress="shouldShowAddress"
                    />
                </div>

                <div class="flex justify-center mt-5 md:mt-7">
                    <Link href="/katalog" class="flex">
                        <Button 
                            variant="landing" 
                            class="flex items-center gap-2 px-4 py-1.5 md:py-6 text-base md:text-xl">
                            <span>Lihat Lebih Banyak</span>
                            <img src="/images/icons/arrow-circle-right-bold.svg" alt="View more" class="w-4 h-4 md:w-6 md:h-6" />
                        </Button>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <Footer />
    </div>
</template>