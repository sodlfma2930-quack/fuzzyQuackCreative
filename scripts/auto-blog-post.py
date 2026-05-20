import json
import datetime
import anthropic
from pathlib import Path

POSTS_PATH = Path("writable/data/posts.json")
BLOG_DIR = Path("docs/blog")
INDEX_PATH = BLOG_DIR / "index.html"

def load_posts():
    with open(POSTS_PATH, encoding="utf-8") as f:
        return json.load(f)

def save_posts(posts):
    with open(POSTS_PATH, "w", encoding="utf-8") as f:
        json.dump(posts, f, ensure_ascii=False, indent=2)
        f.write("\n")

def generate_post(existing_posts):
    client = anthropic.Anthropic()
    existing_titles = [p["title"] for p in existing_posts]
    existing_list = "\n".join(f"- {t}" for t in existing_titles)

    response = client.messages.create(
        model="claude-sonnet-4-6",
        max_tokens=2048,
        messages=[{
            "role": "user",
            "content": f"""You are a Korean tech blog writer. Write ONE new blog post.

Existing posts (do NOT duplicate these topics):
{existing_list}

Pick a practical web development / software engineering topic.
Categories: Frontend, Backend, DevOps, Database, API Design, Architecture, Tools, Testing, Security, Performance.

Respond in this exact JSON format (no markdown, no code fences):
{{
  "title": "Korean title here",
  "slug": "english-kebab-case-slug",
  "content": "Korean blog content here. Use \\n for line breaks between paragraphs. Write 8-15 paragraphs. Be practical and informative. Include concrete examples."
}}

Rules:
- title and content must be in Korean
- slug must be in English kebab-case
- content should be plain text with \\n separators, no markdown headers
- Be practical, informative, include real examples or code concepts"""
        }]
    )

    return json.loads(response.content[0].text)

def create_article_html(title, date, content):
    return f"""<!DOCTYPE html>
<html lang="ko">
<head>
\t<meta charset="utf-8">
\t<meta name="viewport" content="width=device-width, initial-scale=1">
\t<title>{title} — Tech Blog</title>
\t<link rel="preconnect" href="https://fonts.googleapis.com">
\t<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
\t<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;600&family=Noto+Sans+KR:wght@300;400;500&display=swap" rel="stylesheet">
\t<style>
\t\t*, *::before, *::after {{ box-sizing: border-box; margin: 0; padding: 0; }}
\t\tbody {{ font-family: 'Noto Sans KR', -apple-system, sans-serif; background: #fafafa; color: #1d1d1f; }}
\t\t.header {{ background: #fff; border-bottom: 1px solid #e5e5ea; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; }}
\t\t.header__title {{ font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 600; }}
\t\t.header__back {{ font-size: 14px; color: #0071e3; text-decoration: none; }}
\t\t.article {{ max-width: 680px; margin: 0 auto; padding: 40px 20px; }}
\t\t.article__date {{ font-size: 13px; color: #86868b; margin-bottom: 8px; }}
\t\t.article__title {{ font-size: 26px; font-weight: 600; line-height: 1.4; margin-bottom: 24px; }}
\t\t.article__content {{ font-size: 15px; line-height: 1.8; color: #333; white-space: pre-wrap; word-break: keep-all; }}
\t</style>
</head>
<body>
\t<header class="header">
\t\t<div class="header__title">Tech Blog</div>
\t\t<a class="header__back" href="./index.html">← 목록으로</a>
\t</header>
\t<article class="article">
\t\t<p class="article__date">{date}</p>
\t\t<h1 class="article__title">{title}</h1>
\t\t<div class="article__content">{content}</div>
\t</article>
</body>
</html>"""

def update_index(slug, title, date, content):
    excerpt = content.replace("\n", " ")[:60] + "..."
    new_card = f"""\t\t\t<li>
\t\t\t\t<a class="post-card" href="./{slug}.html">
\t\t\t\t\t<div class="post-card__thumb">\U0001f4dd</div>
\t\t\t\t\t<div class="post-card__body">
\t\t\t\t\t\t<div class="post-card__date">{date}</div>
\t\t\t\t\t\t<h2 class="post-card__title">{title}</h2>
\t\t\t\t\t\t<p class="post-card__excerpt">{excerpt}</p>
\t\t\t\t\t</div>
\t\t\t\t</a>
\t\t\t</li>"""

    index_html = INDEX_PATH.read_text(encoding="utf-8")
    marker = '<ul class="post-list">'
    index_html = index_html.replace(marker, marker + "\n" + new_card)
    INDEX_PATH.write_text(index_html, encoding="utf-8")

def main():
    posts = load_posts()
    generated = generate_post(posts)

    today = datetime.date.today().isoformat()
    new_id = max(p["id"] for p in posts) + 1

    new_post = {
        "id": new_id,
        "title": generated["title"],
        "slug": generated["slug"],
        "content": generated["content"],
        "thumbnail": "",
        "created_at": today,
    }
    posts.append(new_post)
    save_posts(posts)

    article_html = create_article_html(
        generated["title"], today, generated["content"]
    )
    (BLOG_DIR / f"{generated['slug']}.html").write_text(
        article_html, encoding="utf-8"
    )

    update_index(generated["slug"], generated["title"], today, generated["content"])

    print(f"Posted: {generated['title']} ({generated['slug']})")

if __name__ == "__main__":
    main()
