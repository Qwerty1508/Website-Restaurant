import { useState } from 'react';
import { motion, AnimatePresence } from 'motion/react';
import { X, ZoomIn } from 'lucide-react';

interface GallerySectionProps {
  images: {
    img1: string;
    img2: string;
    img3: string;
    img4: string;
    img5: string;
    img6: string;
  };
}

const tabs = ['Semua', 'Patroli', 'Kegiatan', 'Acara'];

export function GallerySection({ images }: GallerySectionProps) {
  const [activeTab, setActiveTab] = useState(0);
  const [selectedImage, setSelectedImage] = useState<string | null>(null);

  const imageArray = [
    images.img1, images.img2, images.img3,
    images.img4, images.img5, images.img6,
    images.img4, images.img5, images.img6
  ];

  return (
    <section className="relative px-4 md:px-8 lg:px-32 py-20">
      {/* Section Header */}
      <motion.div
        className="flex items-center gap-4 mb-8"
        initial={{ x: -50, opacity: 0 }}
        whileInView={{ x: 0, opacity: 1 }}
        viewport={{ once: true, amount: 0.5 }}
        transition={{ duration: 0.6 }}
      >
        <motion.div
          className="w-1 h-8 bg-[#DC143C]"
          initial={{ height: 0 }}
          whileInView={{ height: 32 }}
          viewport={{ once: true }}
          transition={{ duration: 0.5, delay: 0.2 }}
        />
        <h2 className="text-white text-2xl md:text-4xl font-semibold">Galeri Kegiatan</h2>
      </motion.div>

      {/* Tabs */}
      <motion.div
        className="flex gap-3 md:gap-4 mb-8 overflow-x-auto pb-2"
        initial={{ y: 20, opacity: 0 }}
        whileInView={{ y: 0, opacity: 1 }}
        viewport={{ once: true }}
        transition={{ duration: 0.6, delay: 0.3 }}
      >
        {tabs.map((tab, index) => (
          <motion.button
            key={tab}
            className={`relative px-4 md:px-6 py-2 md:py-3 rounded-full font-semibold whitespace-nowrap transition-colors text-sm md:text-base ${
              activeTab === index
                ? 'text-[#0A1F44]'
                : 'text-white'
            }`}
            onClick={() => setActiveTab(index)}
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.95 }}
          >
            {/* Background with Slide Animation */}
            {activeTab === index && (
              <motion.div
                className="absolute inset-0 bg-[#FFD700] rounded-full"
                layoutId="activeTab"
                transition={{ type: "spring", stiffness: 300, damping: 30 }}
              />
            )}
            
            {activeTab !== index && (
              <div className="absolute inset-0 bg-[rgba(255,255,255,0.1)] backdrop-blur-sm rounded-full border border-white/30" />
            )}
            
            <span className="relative z-10">{tab}</span>
          </motion.button>
        ))}
      </motion.div>

      {/* Gallery Grid */}
      <div className="bg-[#1e1e1e] rounded-[30px] overflow-hidden p-8">
        <motion.div
          className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6, delay: 0.4 }}
        >
          {imageArray.map((img, index) => (
            <motion.div
              key={index}
              className="relative aspect-[4/3] rounded-xl overflow-hidden cursor-pointer group"
              initial={{ scale: 0.8, opacity: 0 }}
              whileInView={{ scale: 1, opacity: 1 }}
              viewport={{ once: true, amount: 0.2 }}
              transition={{
                duration: 0.5,
                delay: index * 0.1,
                type: "spring",
                stiffness: 100
              }}
              onClick={() => setSelectedImage(img)}
              whileHover={{
                rotateX: 5,
                rotateY: 5,
                scale: 1.05,
              }}
              style={{ perspective: 1000 }}
            >
              {/* Image with Blur-up Effect */}
              <motion.img
                src={img}
                alt={`Gallery ${index + 1}`}
                className="absolute inset-0 w-full h-full object-cover"
                initial={{ filter: 'blur(10px)' }}
                whileInView={{ filter: 'blur(0px)' }}
                viewport={{ once: true }}
                transition={{ duration: 0.5 }}
              />

              {/* Glassmorphism Overlay */}
              <motion.div
                className="absolute inset-0 bg-gradient-to-t from-[rgba(10,31,68,0.9)] via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                style={{ backdropFilter: 'blur(10px)' }}
              >
                <div className="absolute bottom-4 left-4 right-4 flex items-center justify-between">
                  <span className="text-white font-semibold">Lihat Detail</span>
                  <motion.div
                    whileHover={{ scale: 1.2, rotate: 90 }}
                    transition={{ duration: 0.3 }}
                  >
                    <ZoomIn className="w-6 h-6 text-[#FFD700]" />
                  </motion.div>
                </div>
              </motion.div>

              {/* Glow Effect on Hover */}
              <motion.div
                className="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                style={{
                  background: 'radial-gradient(circle at center, rgba(0,102,204,0.4) 0%, transparent 70%)',
                  pointerEvents: 'none'
                }}
              />

              {/* Floating Number Badge */}
              <motion.div
                className="absolute top-4 left-4 w-8 h-8 bg-[#FFD700] rounded-full flex items-center justify-center font-bold text-[#0A1F44]"
                initial={{ scale: 0 }}
                whileInView={{ scale: 1 }}
                viewport={{ once: true }}
                transition={{ delay: index * 0.1 + 0.3, type: "spring" }}
                animate={{
                  y: [0, -5, 0],
                }}
                whileHover={{
                  rotate: 360,
                }}
                transition={{
                  y: {
                    duration: 2,
                    repeat: Infinity,
                    ease: "easeInOut"
                  },
                  rotate: {
                    duration: 0.5
                  }
                }}
              >
                {index + 1}
              </motion.div>
            </motion.div>
          ))}
        </motion.div>
      </div>

      {/* Modal for Full Image View */}
      <AnimatePresence>
        {selectedImage && (
          <motion.div
            className="fixed inset-0 bg-black/90 backdrop-blur-md z-50 flex items-center justify-center p-8"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            onClick={() => setSelectedImage(null)}
          >
            {/* Close Button */}
            <motion.button
              className="absolute top-8 right-8 p-4 bg-white/10 backdrop-blur-sm rounded-full hover:bg-white/20 transition-colors"
              whileHover={{ scale: 1.1, rotate: 90 }}
              whileTap={{ scale: 0.9 }}
              onClick={() => setSelectedImage(null)}
            >
              <X className="w-6 h-6 text-white" />
            </motion.button>

            {/* Image */}
            <motion.img
              src={selectedImage}
              alt="Full View"
              className="max-w-full max-h-full object-contain rounded-2xl"
              initial={{ scale: 0.8, opacity: 0 }}
              animate={{ scale: 1, opacity: 1 }}
              exit={{ scale: 0.8, opacity: 0 }}
              transition={{ type: "spring", stiffness: 300, damping: 30 }}
              onClick={(e) => e.stopPropagation()}
            />
          </motion.div>
        )}
      </AnimatePresence>
    </section>
  );
}