import { useState } from 'react';
import { motion, AnimatePresence } from 'motion/react';
import { FileText, UserCheck, Phone, ArrowRight } from 'lucide-react';

const services = [
  {
    icon: FileText,
    title: 'Informasi SIM',
    description: 'Prosedur dan persyaratan pembuatan SIM.',
    color: '#FFD700',
    link: '#sim'
  },
  {
    icon: UserCheck,
    title: 'Pengajuan SKCK',
    description: 'Layanan online untuk pengajuan SKCK.',
    color: '#0066CC',
    link: '#skck'
  },
  {
    icon: Phone,
    title: 'Kontak Polsek',
    description: 'Daftar kontak Polsek di wilayah Merauke.',
    color: '#DC143C',
    link: '#kontak'
  }
];

export function ServicesSection() {
  const [hoveredIndex, setHoveredIndex] = useState<number | null>(null);

  return (
    <section className="relative px-4 md:px-8 lg:px-32 py-20">
      {/* Section Header */}
      <motion.div
        className="text-center mb-12"
        initial={{ y: 50, opacity: 0 }}
        whileInView={{ y: 0, opacity: 1 }}
        viewport={{ once: true, amount: 0.5 }}
        transition={{ duration: 0.6 }}
      >
        <motion.h2
          className="text-white text-3xl md:text-4xl font-bold mb-4"
          initial={{ y: 20, opacity: 0 }}
          whileInView={{ y: 0, opacity: 1 }}
          viewport={{ once: true }}
          transition={{ delay: 0.2 }}
        >
          Layanan Publik
        </motion.h2>
        <motion.p
          className="text-gray-400 text-base md:text-lg px-4"
          initial={{ y: 20, opacity: 0 }}
          whileInView={{ y: 0, opacity: 1 }}
          viewport={{ once: true }}
          transition={{ delay: 0.3 }}
        >
          Kemudahan akses layanan kepolisian untuk masyarakat
        </motion.p>
      </motion.div>

      {/* Services Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {services.map((service, index) => {
          const Icon = service.icon;
          const isHovered = hoveredIndex === index;

          return (
            <motion.div
              key={index}
              className="relative h-[320px]"
              initial={{ y: 50, opacity: 0 }}
              whileInView={{ y: 0, opacity: 1 }}
              viewport={{ once: true, amount: 0.3 }}
              transition={{ duration: 0.6, delay: index * 0.15 }}
              onMouseEnter={() => setHoveredIndex(index)}
              onMouseLeave={() => setHoveredIndex(null)}
            >
              {/* Card Container */}
              <motion.div
                className="relative h-full bg-[#1e1e1e] rounded-2xl cursor-pointer overflow-hidden border border-white/10"
                whileHover={{ y: -12 }}
                transition={{ duration: 0.3 }}
              >
                {/* Front Content */}
                <AnimatePresence mode="wait">
                  {!isHovered ? (
                    <motion.div
                      key="front"
                      className="absolute inset-0 p-8"
                      initial={{ opacity: 0, scale: 0.9 }}
                      animate={{ opacity: 1, scale: 1 }}
                      exit={{ opacity: 0, scale: 0.9 }}
                      transition={{ duration: 0.3 }}
                    >
                      {/* Icon Container with Glassmorphism */}
                      <motion.div
                        className="relative w-16 h-16 rounded-xl mb-6 flex items-center justify-center overflow-hidden"
                        style={{
                          backgroundColor: `${service.color}20`,
                          backdropFilter: 'blur(10px)'
                        }}
                        animate={{
                          rotate: [0, 360],
                        }}
                        transition={{ duration: 8, repeat: Infinity, ease: "linear" }}
                      >
                        {/* Animated Background Gradient */}
                        <motion.div
                          className="absolute inset-0"
                          animate={{
                            background: [
                              `radial-gradient(circle at 0% 0%, ${service.color}40 0%, transparent 50%)`,
                              `radial-gradient(circle at 100% 100%, ${service.color}40 0%, transparent 50%)`,
                              `radial-gradient(circle at 0% 0%, ${service.color}40 0%, transparent 50%)`
                            ]
                          }}
                          transition={{ duration: 3, repeat: Infinity }}
                        />
                        
                        <Icon 
                          className="relative z-10" 
                          style={{ color: service.color }}
                          size={32}
                        />
                      </motion.div>

                      {/* Title */}
                      <h3 className="text-white text-2xl font-bold mb-4">
                        {service.title}
                      </h3>

                      {/* Description */}
                      <p className="text-gray-400 text-base leading-relaxed">
                        {service.description}
                      </p>

                      {/* Hover Hint */}
                      <motion.div
                        className="absolute bottom-6 right-6 text-gray-500 text-sm"
                        animate={{
                          opacity: [0.3, 0.7, 0.3],
                        }}
                        transition={{ duration: 2, repeat: Infinity }}
                      >
                        Hover untuk detail →
                      </motion.div>

                      {/* Decorative Elements */}
                      <motion.div
                        className="absolute top-4 right-4 w-24 h-24 rounded-full opacity-10"
                        style={{ backgroundColor: service.color }}
                        animate={{
                          scale: [1, 1.2, 1],
                          rotate: [0, 180, 360]
                        }}
                        transition={{ duration: 5, repeat: Infinity }}
                      />
                    </motion.div>
                  ) : (
                    <motion.div
                      key="back"
                      className="absolute inset-0 p-8 flex flex-col items-center justify-center text-center"
                      initial={{ opacity: 0, scale: 0.9 }}
                      animate={{ opacity: 1, scale: 1 }}
                      exit={{ opacity: 0, scale: 0.9 }}
                      transition={{ duration: 0.3 }}
                      style={{
                        background: `linear-gradient(135deg, ${service.color}20 0%, rgba(30,30,30,0.95) 100%)`
                      }}
                    >
                      <motion.div
                        initial={{ scale: 0, rotate: -180 }}
                        animate={{ scale: 1, rotate: 0 }}
                        transition={{ delay: 0.1, type: "spring", stiffness: 200 }}
                      >
                        <Icon 
                          style={{ color: service.color }}
                          size={64}
                          className="mb-6"
                        />
                      </motion.div>

                      <motion.h3
                        className="text-white text-2xl font-bold mb-6"
                        initial={{ y: 20, opacity: 0 }}
                        animate={{ y: 0, opacity: 1 }}
                        transition={{ delay: 0.2 }}
                      >
                        {service.title}
                      </motion.h3>

                      <motion.a
                        href={service.link}
                        className="flex items-center justify-center gap-2 px-8 py-4 rounded-full font-semibold text-lg"
                        style={{
                          backgroundColor: service.color,
                          color: '#0A1F44'
                        }}
                        initial={{ y: 20, opacity: 0 }}
                        animate={{ y: 0, opacity: 1 }}
                        transition={{ delay: 0.3 }}
                        whileHover={{ scale: 1.05, gap: '16px' }}
                        whileTap={{ scale: 0.95 }}
                      >
                        Akses Layanan
                        <ArrowRight size={20} />
                      </motion.a>

                      {/* Animated Border */}
                      <motion.div
                        className="absolute inset-0 rounded-2xl"
                        style={{
                          border: `2px solid ${service.color}`,
                          opacity: 0.5
                        }}
                        animate={{
                          scale: [1, 1.02, 1],
                          opacity: [0.5, 0.8, 0.5]
                        }}
                        transition={{ duration: 2, repeat: Infinity }}
                      />
                    </motion.div>
                  )}
                </AnimatePresence>

                {/* Glow Effect on Hover */}
                <motion.div
                  className="absolute inset-0 rounded-2xl pointer-events-none"
                  animate={{
                    opacity: isHovered ? 0.4 : 0,
                  }}
                  transition={{ duration: 0.3 }}
                  style={{
                    background: `radial-gradient(circle at 50% 50%, ${service.color} 0%, transparent 70%)`,
                    filter: 'blur(30px)'
                  }}
                />
              </motion.div>

              {/* Shadow Morph on Hover */}
              <motion.div
                className="absolute inset-0 -z-10 rounded-2xl"
                animate={{
                  opacity: isHovered ? 0.6 : 0,
                  scale: isHovered ? 1.05 : 1,
                }}
                transition={{ duration: 0.3 }}
                style={{
                  background: `linear-gradient(135deg, ${service.color}60 0%, transparent 100%)`,
                  filter: 'blur(40px)'
                }}
              />
            </motion.div>
          );
        })}
      </div>

      {/* CTA Section */}
      <motion.div
        className="mt-16 text-center"
        initial={{ y: 50, opacity: 0 }}
        whileInView={{ y: 0, opacity: 1 }}
        viewport={{ once: true }}
        transition={{ duration: 0.6, delay: 0.5 }}
      >
        <motion.button
          className="px-8 py-4 bg-gradient-to-r from-[#0066CC] to-[#0A1F44] text-white rounded-full font-semibold shadow-lg relative overflow-hidden group"
          whileHover={{ scale: 1.05 }}
          whileTap={{ scale: 0.95 }}
        >
          <motion.div
            className="absolute inset-0 bg-[#FFD700]"
            initial={{ x: '-100%' }}
            whileHover={{ x: 0 }}
            transition={{ duration: 0.3 }}
          />
          <span className="relative z-10 group-hover:text-[#0A1F44] transition-colors inline-flex items-center gap-2">
            Lihat Semua Layanan
            <motion.span
              animate={{ x: [0, 5, 0] }}
              transition={{ duration: 1.5, repeat: Infinity }}
            >
              →
            </motion.span>
          </span>
        </motion.button>
      </motion.div>
    </section>
  );
}