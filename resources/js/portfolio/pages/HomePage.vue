<template>
    <div>
        <!-- Skeleton while loading -->
        <div v-if="loading" class="flex min-h-screen items-center justify-center">
            <div class="text-center">
                <div class="mx-auto mb-4 h-16 w-16 animate-spin rounded-full border-4 border-t-transparent" style="border-color: var(--p-primary); border-top-color: transparent" />
                <p style="color: var(--p-muted)">Loading portfolio...</p>
            </div>
        </div>

        <template v-else>
            <HeroSection />
            <AboutSection />
            <SkillsSection />
            <ServicesSection />
            <PortfolioSection />
            <ExperienceSection />
            <BeeHookSection />
            <TestimonialsSection />
            <BlogSection />
            <ContactSection />
        </template>
    </div>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { useContentStore } from '@/portfolio/stores/useContentStore';
import HeroSection from '@/portfolio/components/sections/HeroSection.vue';
import AboutSection from '@/portfolio/components/sections/AboutSection.vue';
import SkillsSection from '@/portfolio/components/sections/SkillsSection.vue';
import ServicesSection from '@/portfolio/components/sections/ServicesSection.vue';
import PortfolioSection from '@/portfolio/components/sections/PortfolioSection.vue';
import ExperienceSection from '@/portfolio/components/sections/ExperienceSection.vue';
import BeeHookSection from '@/portfolio/components/sections/BeeHookSection.vue';
import TestimonialsSection from '@/portfolio/components/sections/TestimonialsSection.vue';
import BlogSection from '@/portfolio/components/sections/BlogSection.vue';
import ContactSection from '@/portfolio/components/sections/ContactSection.vue';

const { loading } = storeToRefs(useContentStore());
</script>
