<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use Illuminate\Support\Str;

class MedicalPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'The Future of Telemedicine: Healthcare from Home',
                'excerpt' => 'Discover how virtual consultations and remote monitoring are revolutionizing patient care, making specialists more accessible than ever.',
                'content' => '<h3>A New Era of Healthcare</h3><p>Telemedicine has rapidly transformed from a convenient alternative to an essential pillar of modern healthcare. With advancements in secure video conferencing, wearable health trackers, and AI-driven diagnostics, patients can now receive world-class medical advice without leaving their homes.</p><p>At KAAFI Hospitals, we are integrating these technologies to ensure our patients have 24/7 access to care, reducing emergency room wait times and providing continuous support for chronic disease management.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
            ],
            [
                'title' => 'Understanding Cardiovascular Health in 2026',
                'excerpt' => 'A comprehensive guide to preventing heart disease through modern nutrition, stress management, and early screening.',
                'content' => '<h3>Your Heart is Your Engine</h3><p>Cardiovascular disease remains a leading health concern globally. However, modern medicine has made incredible strides in early detection and preventative care. Simple lifestyle adjustments, combined with routine ECGs and cholesterol monitoring, can reduce risks by over 70%.</p><p>In this article, our leading cardiologists discuss the importance of Mediterranean diets, cardiovascular exercise routines, and the warning signs you should never ignore.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1530497610245-94d3c16cda28?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
            ],
            [
                'title' => 'Pediatric Care: Milestones Every Parent Should Know',
                'excerpt' => 'From first steps to cognitive development, learn what to watch for as your child grows and when to consult a pediatrician.',
                'content' => '<h3>Guiding the Next Generation</h3><p>Children grow at their own pace, but understanding standard developmental milestones can help parents ensure their little ones are thriving. From motor skills to speech development, early intervention is key if you suspect any delays.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1584515933487-779824d29309?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
            ],
            [
                'title' => 'The Science of Sleep: Why Rest is the Best Medicine',
                'excerpt' => 'Chronic sleep deprivation is linked to numerous health issues. Learn the clinical importance of sleep hygiene.',
                'content' => '<h3>Recharging the Brain</h3><p>Sleep is not a luxury; it is a biological necessity. During deep sleep, the brain flushes out toxins and the immune system repairs cellular damage. Lack of sleep is now clinically linked to hypertension, diabetes, and weakened immunity.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1542884748-2b87b36c6b90?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
            ],
            [
                'title' => 'Advances in Minimally Invasive Surgery',
                'excerpt' => 'How robotic assistance and laparoscopy are reducing recovery times from weeks to mere days.',
                'content' => '<h3>Precision Meets Care</h3><p>The days of large surgical incisions are fading. With robotic arms that offer greater precision than the human hand, surgeons at KAAFI can perform complex procedures through incisions no larger than a keyhole. This means less pain, minimal scarring, and drastically faster recovery times for our patients.</p>',
                'featured_image_url' => 'https://images.unsplash.com/photo-1551076805-e1869033e561?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
            ],
        ];

        foreach ($posts as $post) {
            $title = $post['title'];
            $slug = Str::slug($title);
            
            // Handle translations manually if the model uses Spatie Translatable
            $post['title'] = ['en' => $title];
            $post['excerpt'] = ['en' => $post['excerpt']];
            $post['content'] = ['en' => $post['content']];
            
            BlogPost::updateOrCreate(['slug' => $slug], $post);
        }
    }
}
