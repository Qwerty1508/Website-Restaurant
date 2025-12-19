import { useEffect, useState } from 'react';
import { motion, useScroll, useTransform, useInView } from 'motion/react';
import { Header } from './components/Header';
import { HeroSection } from './components/HeroSection';
import { NewsSection } from './components/NewsSection';
import { PopularNews } from './components/PopularNews';
import { HottestNews } from './components/HottestNews';
import { GallerySection } from './components/GallerySection';
import { ServicesSection } from './components/ServicesSection';
import { Footer } from './components/Footer';
import imgRectangle2 from "figma:asset/2b95971bdaebb513bb44426be49b09876a44c61d.png";
import imgImage3 from "figma:asset/1531440db449130222b2e312a5747a01dd85c2c1.png";
import imgRectangle7 from "figma:asset/3c53122fd54eb863656dc092a10f828ce55424a9.png";
import imgRectangle8 from "figma:asset/5317890f9561275ac5a564602baba1e67d32d6d0.png";
import imgRectangle10 from "figma:asset/8e325536ae4e01e73afc6093902a8260509d6343.png";
import imgRectangle9 from "figma:asset/10e620a1668b418d3e3554d1982e829cee1dc31d.png";
import imgRectangle12 from "figma:asset/d5d7f045d41386f6227cd09ef77a9cc2515c4efa.png";
import imgRectangle14 from "figma:asset/d55ddf123ba7bf122947744f66c4550508dc1b08.png";
import imgRectangle13 from "figma:asset/6408b05264619dbe229e6690e5ff2fbdc53c983b.png";
import imgRectangle15 from "figma:asset/d3905ff58554e19f75826ca2d23641c61745f126.png";
import imgRectangle19 from "figma:asset/4a77fd5ed347167a0912b013a8682a637c805169.png";
import imgRectangle20 from "figma:asset/41b292750d981f42bc651da3d889d2258a77eca2.png";
import imgRectangle18 from "figma:asset/9534863196a135bab2785dce0e65162d06772c59.png";
import imgRectangle17 from "figma:asset/0a2b55cdbb99437eec167c119e56dbd51806b7c0.png";
import imgRectangle16 from "figma:asset/d31a7007192c4b5d54289ece969d7676ca75df4f.png";

export default function App() {
  const { scrollY } = useScroll();
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    // Simulate loading
    const timer = setTimeout(() => {
      setIsLoading(false);
    }, 1000);
    return () => clearTimeout(timer);
  }, []);

  if (isLoading) {
    return (
      <div className="fixed inset-0 bg-[#0A1F44] flex items-center justify-center z-50 p-4">
        <motion.div
          className="relative text-center"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
        >
          {/* Siren Light Effect */}
          <motion.div
            className="absolute -top-8 left-1/2 -translate-x-1/2 w-24 md:w-32 h-1"
            animate={{
              background: [
                'linear-gradient(90deg, #DC143C 0%, #0066CC 50%, #DC143C 100%)',
                'linear-gradient(90deg, #0066CC 0%, #DC143C 50%, #0066CC 100%)',
                'linear-gradient(90deg, #DC143C 0%, #0066CC 50%, #DC143C 100%)',
              ],
            }}
            transition={{ duration: 1, repeat: Infinity }}
          />
          
          <motion.div
            className="text-[#FFD700] text-3xl md:text-6xl font-bold px-4"
            animate={{
              scale: [1, 1.1, 1],
              opacity: [0.5, 1, 0.5],
            }}
            transition={{ duration: 2, repeat: Infinity }}
          >
            POLRES MERAUKE
          </motion.div>
        </motion.div>
      </div>
    );
  }

  return (
    <div className="bg-[#191919] relative w-full min-h-screen overflow-x-hidden">
      {/* Background Pattern - Papua Batik Watermark */}
      <div className="fixed inset-0 opacity-5 pointer-events-none">
        <div className="absolute inset-0" style={{
          backgroundImage: 'radial-gradient(circle, #FFD700 1px, transparent 1px)',
          backgroundSize: '50px 50px'
        }} />
      </div>

      <Header />
      <HeroSection />
      
      {/* Main Berita Terbaru */}
      <motion.section
        className="relative px-4 md:px-8 lg:px-32 pt-20"
        initial={{ opacity: 0 }}
        whileInView={{ opacity: 1 }}
        viewport={{ once: true, amount: 0.3 }}
        transition={{ duration: 0.6 }}
      >
        <motion.div
          className="flex items-center gap-4 mb-8"
          initial={{ x: -50, opacity: 0 }}
          whileInView={{ x: 0, opacity: 1 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6 }}
        >
          <motion.div
            className="w-1 h-8 bg-[#DC143C]"
            animate={{ height: [0, 32] }}
            transition={{ duration: 0.5 }}
          />
          <h2 className="text-white text-2xl md:text-3xl font-semibold">Berita Tebaru</h2>
        </motion.div>

        <motion.div
          className="relative bg-white rounded-[20px] md:rounded-[30px] overflow-hidden cursor-pointer group"
          initial={{ y: 50, opacity: 0 }}
          whileInView={{ y: 0, opacity: 1 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6, delay: 0.2 }}
          whileHover={{ scale: 1.02, y: -8 }}
        >
          {/* Glassmorphism Overlay on Hover */}
          <motion.div
            className="absolute inset-0 bg-gradient-to-t from-[rgba(10,31,68,0.9)] via-[rgba(10,31,68,0.5)] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10"
            style={{ backdropFilter: 'blur(10px)' }}
          />
          
          <div className="relative h-[400px] md:h-[600px] lg:h-[781px]">
            <motion.img
              src={imgImage3}
              alt="Berita Utama"
              className="absolute inset-0 w-full h-full object-cover rounded-[21px]"
              whileHover={{ scale: 1.05 }}
              transition={{ duration: 5, ease: "linear" }}
            />
            
            <div className="absolute inset-0 p-6 md:p-12 flex flex-col justify-end z-20">
              <motion.h3
                className="text-white text-xl md:text-3xl font-bold mb-4 drop-shadow-lg"
                initial={{ y: 20, opacity: 0 }}
                whileInView={{ y: 0, opacity: 1 }}
                viewport={{ once: true }}
                transition={{ delay: 0.3 }}
              >
                Polres Merauke Gelar Operasi Zebra 2025, Fokus Pada Keselamatan Berkendara.
              </motion.h3>
              <motion.p
                className="text-white text-base md:text-lg drop-shadow-lg"
                initial={{ y: 20, opacity: 0 }}
                whileInView={{ y: 0, opacity: 1 }}
                viewport={{ once: true }}
                transition={{ delay: 0.4 }}
              >
                Kamis, 27 November 2025
              </motion.p>
            </div>
          </div>
        </motion.div>
      </motion.section>

      {/* Berita Populer */}
      <PopularNews 
        images={{
          img1: imgRectangle7,
          img2: imgRectangle8,
          img3: imgRectangle9,
          img4: imgRectangle10
        }}
      />

      {/* Berita Terhangat */}
      <HottestNews 
        images={{
          img1: imgRectangle12,
          img2: imgRectangle13,
          img3: imgRectangle14
        }}
      />

      {/* Galeri Kegiatan */}
      <GallerySection 
        images={{
          img1: imgRectangle15,
          img2: imgRectangle16,
          img3: imgRectangle17,
          img4: imgRectangle18,
          img5: imgRectangle19,
          img6: imgRectangle20
        }}
      />

      {/* Layanan Publik */}
      <ServicesSection />

      {/* Footer */}
      <Footer />
    </div>
  );
}