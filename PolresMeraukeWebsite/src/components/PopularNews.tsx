import { motion } from 'motion/react';
import { Calendar } from 'lucide-react';

interface PopularNewsProps {
  images: {
    img1: string;
    img2: string;
    img3: string;
    img4: string;
  };
}

const newsItems = [
  {
    title: 'Polres Merauke Lakukan Patroli Dialogis Harkamtibmas',
    date: '28 Agustus 2025',
    img: 'img1'
  },
  {
    title: 'Bhabinkamtibmas Polres Merauke Latih Linmas, Sambut HUT Proklamasi Kemerdekaan RI.',
    date: '18 November 2025',
    img: 'img2'
  },
  {
    title: 'Pembinaan dan Penyuluhan Kepada Masyarakat Sota Melalui FKPM.',
    date: '20 Desember 2025',
    img: 'img3'
  },
  {
    title: 'Polsek Sota Laksanakan Sambang Kampung, dan Membantu Mengedukasi Perekonomian Warga.',
    date: '30 Oktober 2025',
    img: 'img4'
  }
];

export function PopularNews({ images }: PopularNewsProps) {
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
        <h2 className="text-white text-2xl md:text-3xl font-semibold">Berita Popular</h2>
      </motion.div>

      {/* News Grid */}
      <div className="bg-[#1e1e1e] rounded-[20px] md:rounded-[30px] overflow-hidden p-4 md:p-8">
        <div className="grid md:grid-cols-2 gap-4 md:gap-8">
          {/* Main Featured News */}
          <motion.div
            className="lg:row-span-2"
            initial={{ x: -50, opacity: 0 }}
            whileInView={{ x: 0, opacity: 1 }}
            viewport={{ once: true, amount: 0.3 }}
            transition={{ duration: 0.6, delay: 0.2 }}
          >
            <motion.div
              className="relative h-full rounded-xl overflow-hidden cursor-pointer group"
              whileHover={{ y: -8 }}
              transition={{ duration: 0.3 }}
            >
              {/* Glassmorphism Overlay */}
              <motion.div
                className="absolute inset-0 bg-gradient-to-t from-[rgba(10,31,68,0.95)] to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-500 z-10"
                style={{ backdropFilter: 'blur(5px)' }}
              />

              <motion.img
                src={images.img1}
                alt={newsItems[0].title}
                className="absolute inset-0 w-full h-full object-cover"
                whileHover={{ scale: 1.1 }}
                transition={{ duration: 0.5 }}
              />

              <div className="relative z-20 h-full flex flex-col justify-end p-8">
                <motion.div
                  className="inline-flex items-center gap-2 bg-[rgba(255,215,0,0.2)] backdrop-blur-md px-4 py-2 rounded-full mb-4 w-fit"
                  initial={{ scale: 0 }}
                  whileInView={{ scale: 1 }}
                  viewport={{ once: true }}
                  transition={{ delay: 0.5, type: "spring" }}
                >
                  <Calendar className="w-4 h-4 text-[#FFD700]" />
                  <span className="text-white text-sm">{newsItems[0].date}</span>
                </motion.div>

                <motion.h3
                  className="text-white text-2xl font-semibold"
                  initial={{ y: 20, opacity: 0 }}
                  whileInView={{ y: 0, opacity: 1 }}
                  viewport={{ once: true }}
                  transition={{ delay: 0.6 }}
                >
                  {newsItems[0].title}
                </motion.h3>
              </div>

              {/* Hover Glow Effect */}
              <motion.div
                className="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                style={{
                  background: 'radial-gradient(circle at center, rgba(0,102,204,0.3) 0%, transparent 70%)',
                  pointerEvents: 'none'
                }}
              />
            </motion.div>
          </motion.div>

          {/* Side News Items */}
          {newsItems.slice(1).map((news, index) => (
            <motion.div
              key={index}
              className="relative"
              initial={{ x: 50, opacity: 0 }}
              whileInView={{ x: 0, opacity: 1 }}
              viewport={{ once: true, amount: 0.3 }}
              transition={{ duration: 0.6, delay: 0.2 + (index * 0.1) }}
            >
              <motion.div
                className="relative h-[150px] rounded-xl overflow-hidden cursor-pointer group flex"
                whileHover={{ x: 8 }}
                transition={{ duration: 0.3 }}
              >
                {/* Image */}
                <div className="relative w-[147px] flex-shrink-0">
                  <motion.img
                    src={images[`img${index + 2}` as keyof typeof images]}
                    alt={news.title}
                    className="absolute inset-0 w-full h-full object-cover rounded-l-xl"
                    whileHover={{ scale: 1.1 }}
                    transition={{ duration: 0.5 }}
                  />
                </div>

                {/* Content with Glassmorphism */}
                <motion.div
                  className="flex-1 bg-[rgba(30,30,30,0.9)] backdrop-blur-sm p-4 flex flex-col justify-between rounded-r-xl border-l-2 border-[#0066CC] group-hover:border-[#FFD700] transition-colors"
                  whileHover={{ backgroundColor: 'rgba(0,102,204,0.1)' }}
                >
                  <h4 className="text-white text-base font-semibold line-clamp-3 group-hover:text-[#FFD700] transition-colors">
                    {news.title}
                  </h4>
                  
                  <motion.div
                    className="flex items-center gap-2 text-white text-sm opacity-70"
                    whileHover={{ opacity: 1 }}
                  >
                    <motion.div
                      animate={{ rotate: [0, 360] }}
                      transition={{ duration: 2, repeat: Infinity, ease: "linear" }}
                    >
                      <Calendar className="w-3 h-3" />
                    </motion.div>
                    <span>{news.date}</span>
                  </motion.div>
                </motion.div>

                {/* Floating Animation */}
                <motion.div
                  className="absolute top-2 right-2 w-2 h-2 bg-[#FFD700] rounded-full opacity-0 group-hover:opacity-100"
                  animate={{
                    y: [0, -8, 0],
                    scale: [1, 1.2, 1],
                  }}
                  transition={{ duration: 1.5, repeat: Infinity }}
                />
              </motion.div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}