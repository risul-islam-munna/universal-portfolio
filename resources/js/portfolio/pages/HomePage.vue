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
            <SkillsSection v-if="skills.length > 0" />
            <ServicesSection v-if="services.length > 0" />
            <PortfolioSection v-if="projects.length > 0" />
            <ExperienceSection v-if="experience.length > 0" />
            <BeeHookSection v-if="businessHighlight" />
            <TestimonialsSection v-if="testimonials.length > 0" />
            <BlogSection v-if="blog.length > 0" />
            <ContactSection />
        </template>
    </div>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import AboutSection from '@/portfolio/components/sections/AboutSection.vue';
import BeeHookSection from '@/portfolio/components/sections/BeeHookSection.vue';
import BlogSection from '@/portfolio/components/sections/BlogSection.vue';
import ContactSection from '@/portfolio/components/sections/ContactSection.vue';
import ExperienceSection from '@/portfolio/components/sections/ExperienceSection.vue';
import HeroSection from '@/portfolio/components/sections/HeroSection.vue';
import PortfolioSection from '@/portfolio/components/sections/PortfolioSection.vue';
import ServicesSection from '@/portfolio/components/sections/ServicesSection.vue';
import SkillsSection from '@/portfolio/components/sections/SkillsSection.vue';
import TestimonialsSection from '@/portfolio/components/sections/TestimonialsSection.vue';
import { useContentStore } from '@/portfolio/stores/useContentStore';

const { loading, skills, services, projects, experience, testimonials, blog, businessHighlight } = storeToRefs(useContentStore());
</script>
