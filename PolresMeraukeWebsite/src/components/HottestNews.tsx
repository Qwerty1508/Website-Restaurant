import { motion } from 'motion/react';
import { Calendar, TrendingUp } from 'lucide-react';

interface HottestNewsProps {
  images: {
    img1: string;
    img2: string;
    img3: string;
  };
}

const newsItems = [
  {
    title: 'Di Merauke, Polantas gencar himbau gunakan Helm dan Masker demi Keselamatan.',
    date: '28 Februari 2025',
    img: 'img1'
  },
  {
    title: 'Satresnarkoba Gagalkan Peredaran Narkotika Jenis Ganja.',
    date: '25 Januari 2025',
    img: 'img2'
  },
  {
    title: 'Pengaturan Lalu Lintas Pagi Hari, Pastikan Aktivitas Warga Lancar.',
    date: '31 Agustus 2025',
    img: 'img3'
  }
];

export function HottestNews({ images }: HottestNewsProps) {
  return (
    <section className="relative px-4 md:px-8 lg:px-32 py-20">
      {/* Section Header with Badge */}
      <motion.div
        className="flex items-center gap-4 mb-8 flex-wrap"
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
        <h2 className="text-white text-2xl md:text-3xl font-semibold">Berita Terhangat</h2>
        
        {/* Trending Badge with Pulse */}
        <motion.div
          className="relative flex items-center gap-2 bg-[#DC143C] px-4 py-2 rounded-full"
          animate={{
            scale: [1, 1.05, 1],
          }}
          transition={{ duration: 2, repeat: Infinity }}
        >
          <motion.div
            animate={{ rotate: [0, 360] }}
            transition={{ duration: 3, repeat: Infinity, ease: "linear" }}
          >
            <TrendingUp className="w-4 h-4 text-white" />
          </motion.div>
          <span className="text-white text-sm font-semibold">TRENDING</span>
          
          {/* Pulse Effect */}
          <motion.div
            className="absolute inset-0 bg-[#DC143C] rounded-full"
            animate={{
              scale: [1, 1.3],
              opacity: [0.5, 0],
            }}
            transition={{ duration: 1.5, repeat: Infinity }}
          />
        </motion.div>
      </motion.div>

      {/* News Grid */}
      <div className="bg-[#1e1e1e] rounded-[30px] overflow-hidden p-8">
        <div className="space-y-6">
          {newsItems.map((news, index) => (
            <motion.div
              key={index}
              className="relative"
              initial={{ y: 50, opacity: 0 }}
              whileInView={{ y: 0, opacity: 1 }}
              viewport={{ once: true, amount: 0.3 }}
              transition={{ duration: 0.6, delay: index * 0.15 }}
            >
              <motion.div
                className="relative flex flex-col md:flex-row gap-4 md:gap-6 cursor-pointer group"
                whileHover={{ y: -4 }}
                transition={{ duration: 0.3 }}
              >
                {/* Image with 3D Tilt Effect */}
                <motion.div
                  className="relative w-full md:w-[436px] h-[200px] md:h-[282px] rounded-xl overflow-hidden flex-shrink-0"
                  whileHover={{
                    rotateY: 5,
                    rotateX: -5,
                  }}
                  transition={{ duration: 0.3 }}
                  style={{ perspective: 1000 }}
                >
                  <motion.img
                    src={images[`img${index + 1}` as keyof typeof images]}
                    alt={news.title}
                    className="absolute inset-0 w-full h-full object-cover rounded-xl"
                    whileHover={{ scale: 1.1 }}
                    transition={{ duration: 0.5 }}
                  />

                  {/* Glassmorphism Overlay */}
                  <motion.div
                    className="absolute inset-0 bg-gradient-to-t from-[rgba(10,31,68,0.8)] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                    style={{ backdropFilter: 'blur(5px)' }}
                  />

                  {/* Glow Effect on Hover */}
                  <motion.div
                    className="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                    style={{
                      background: 'radial-gradient(circle at center, rgba(255,215,0,0.3) 0%, transparent 70%)',
                      pointerEvents: 'none'
                    }}
                  />
                </motion.div>

                {/* Content */}
                <div className="flex-1 flex flex-col justify-center gap-4">
                  <motion.h3
                    className="text-white text-xl md:text-3xl font-medium leading-tight group-hover:text-[#FFD700] transition-colors"
                    initial={{ x: 20, opacity: 0 }}
                    whileInView={{ x: 0, opacity: 1 }}
                    viewport={{ once: true }}
                    transition={{ delay: 0.3 + index * 0.1 }}
                  >
                    {news.title}
                  </motion.h3>

                  <motion.div
                    className="flex items-center gap-3 flex-wrap"
                    initial={{ x: 20, opacity: 0 }}
                    whileInView={{ x: 0, opacity: 1 }}
                    viewport={{ once: true }}
                    transition={{ delay: 0.4 + index * 0.1 }}
                  >
                    {/* Date Badge */}
                    <motion.div
                      className="flex items-center gap-2 bg-[rgba(255,215,0,0.15)] backdrop-blur-md px-4 py-2 rounded-full border border-[#FFD700]/30 group-hover:bg-[rgba(255,215,0,0.25)] transition-colors"
                      whileHover={{ scale: 1.05 }}
                    >
                      <Calendar className="w-4 h-4 text-[#FFD700]" />
                      <span className="text-white text-base">{news.date}</span>
                    </motion.div>

                    {/* Tag */}
                    <motion.div
                      className="px-4 py-2 bg-[#0066CC]/20 backdrop-blur-md rounded-full border border-[#0066CC]/30"
                      animate={{
                        scale: [1, 1.05, 1],
                        opacity: [0.8, 1, 0.8],
                      }}
                      transition={{ duration: 2, repeat: Infinity }}
                    >
                      <span className="text-[#0066CC] text-sm font-semibold">Kegiatan</span>
                    </motion.div>
                  </motion.div>

                  {/* Read More Link */}
                  <motion.a
                    href="#"
                    className="text-[#0066CC] font-semibold text-base flex items-center gap-2 group-hover:gap-4 transition-all"
                    whileHover={{ x: 10 }}
                  >
                    Baca Selengkapnya
                    <motion.span
                      animate={{ x: [0, 5, 0] }}
                      transition={{ duration: 1.5, repeat: Infinity }}
                    >
                      →
                    </motion.span>
                  </motion.a>
                </div>
              </motion.div>

              {/* Divider (except last item) */}
              {index < newsItems.length - 1 && (
                <motion.div
                  className="h-px bg-gradient-to-r from-transparent via-[#FFD700]/30 to-transparent mt-6"
                  initial={{ scaleX: 0 }}
                  whileInView={{ scaleX: 1 }}
                  viewport={{ once: true }}
                  transition={{ duration: 0.8, delay: 0.5 + index * 0.1 }}
                />
              )}
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}