import scrapy

class BlogSpider(scrapy.Spider):
    name = 'blogspider'
    start_urls = ['https://www.halodoc.com/kesehatan']

    def parse(self, response):
        for title in response.css('div.list-obat > span'):
            yield {'title': title.css('a ::text').extract()}

        # for next_page in response.css('div.prev-post > a'):
            # yield response.follow(next_page, self.parse)


